# Phase 5F — Ecommerce Hardening

## Overview

This phase hardens the backend order lifecycle for real-world production use.
It addresses critical gaps identified during an architectural audit of the cart → checkout → order flow.

The audit found **18 risks** ranging from free-order exploits (no payment verification) to silent type
mismatches that block every checkout attempt. This document drives the full resolution backlog.

---

## Goals

1. No order can be placed without a verified, confirmed payment
2. Stock is reserved atomically — overselling is impossible under concurrent load
3. The order state machine is complete and enforced; invalid transitions are rejected
4. Store owners can manage their own order lifecycle via the API (not just via Filament)
5. All critical operations are wrapped in DB transactions and are idempotent
6. A full audit trail exists for every state transition

---

## Risk Register (from Audit)

| # | Risk | Severity | Status |
|---|---|---|---|
| 1 | No payment verification — free orders | 🔴 Critical | TODO |
| 2 | No webhook handler — forgeable success redirect | 🔴 Critical | TODO |
| 3 | Null cart causes fatal 500 in `OrderController::store()` | 🔴 Critical | TODO |
| 4 | Cart not cleared after order — duplicate orders on retry | 🔴 Critical | TODO |
| 5 | No idempotency — double-click / network retry creates duplicates | 🟠 High | TODO |
| 6 | No stock reservation on checkout — overselling under concurrent load | 🟠 High | TODO |
| 7 | `attribute_data` strict type mismatch blocks all `validateCartBelongsToStore()` | 🟠 High | TODO |
| 8 | No `Refunded` / `PaymentFailed` status — incomplete state machine | 🟠 High | TODO |
| 9 | No store owner order management API endpoints | 🟠 High | TODO |
| 10 | `Store::findOrFail()` called in controller instead of service | 🟡 Medium | TODO |
| 11 | Store approval checked twice (FormRequest + Service) | 🟡 Medium | TODO |
| 12 | Float arithmetic in `CommissionService` — rounding drift | 🟡 Medium | TODO |
| 13 | Cart not bound to `user_id` — lost on new device or session expiry | 🟡 Medium | TODO |
| 14 | No `ExpirePendingOrdersJob` — stale orders never cleaned up | 🟡 Medium | TODO |
| 15 | No abandoned cart cleanup job | 🟢 Low | TODO |
| 16 | Direct `notify()` calls instead of dispatching domain events | 🟢 Low | TODO |
| 17 | Audit trail missing actor identity and `from → to` status deltas | 🟢 Low | TODO |
| 18 | `throttle:60,1` too permissive on checkout endpoint | 🟢 Low | TODO |

---

## Deliverables

### Backend

#### A. Critical Fixes (zero-regression, ship immediately)

- [ ] **#3** — Guard against null cart in `OrderController::store()`: return 422 if `CartSession::current()` is null
- [ ] **#4** — Clear cart session after successful order creation in `OrderService::createFromCart()`
- [ ] **#7** — Fix `validateCartBelongsToStore()` type coercion: cast `attribute_data` store_id to `int` before strict comparison; handle null attribute gracefully
- [ ] **#18** — Apply `throttle:5,1` to `POST /orders` separately from the browse group

#### B. State Machine Hardening

- [ ] **#8** — Add `PaymentFailed`, `RefundPending`, `Refunded` cases to `OrderStatus` enum
- [ ] **#8** — Restrict `cancel()` in `OrderPolicy`: customers may only cancel from `Pending`; store owners may cancel from any active status
- [ ] **#8** — Add `canTransitionTo(OrderStatus $next): bool` helper on `OrderStatus` enum with an explicit transition matrix
- [ ] **#9** — Add store-owner order management routes:
  - `PATCH /api/v1/orders/{order}/confirm`
  - `PATCH /api/v1/orders/{order}/prepare`
  - `PATCH /api/v1/orders/{order}/ready`
  - `PATCH /api/v1/orders/{order}/deliver`
- [ ] **#9** — Add `OrderPolicy::confirm/prepare/ready/deliver` gates (store owner of that order only)

#### C. Payment Integration — PayMongo

- [ ] **#1 + #2** — Install and configure Lunar's PayMongo driver (or implement a thin wrapper)
- [ ] **#1** — `POST /api/v1/orders/intent` — create a PayMongo payment intent, return `{ client_key, payment_intent_id }`
- [ ] **#2** — `POST /webhooks/paymongo` — verify HMAC signature, handle `payment.paid` and `payment.failed` events
- [ ] **#2** — Webhook controller transitions order to `Confirmed` (on paid) or `PaymentFailed` (on failed) — never trust frontend redirects
- [ ] Webhook route is **outside** the `auth:sanctum` middleware group (public, signature-verified)
- [ ] Store `payment_intent_id` and `payment_status` on the order (new migration)

#### D. Idempotency & Concurrency

- [ ] **#5** — Wrap `OrderService::createFromCart()` in a Redis/cache distributed lock keyed by `user_{id}_order_create` with a 15-second TTL; return 409 if lock already held
- [ ] **#5** — Accept an optional `X-Idempotency-Key` header; cache the first 201 response for 24 hours keyed to it
- [ ] **#6** — Check available stock per variant in `OrderService::validateCart()` before creating the order
- [ ] **#6** — Use `lockForUpdate()` on `ProductVariant` rows inside the DB transaction to prevent race conditions
- [ ] **#6** — Decrement `ProductVariant::stock` within the transaction in `createFromCart()`
- [ ] **#6** — Restore stock in `OrderService::cancel()` and in the PayMongo `payment.failed` webhook handler

#### E. Service Layer Cleanup

- [ ] **#10** — Move `Store::findOrFail()` out of `OrderController::store()` into the service
- [ ] **#11** — Remove redundant store-approval check from `PlaceOrderRequest::after()` — `OrderService::validateStore()` is authoritative
- [ ] **#12** — Replace float commission arithmetic with integer-only math: `(int) round((int) $total * (int) round($rate * 100) / 10000)`
- [ ] **#13** — Configure `config/lunar/cart_session.php` to persist carts to DB and associate with `user_id` on authentication; implement guest→auth cart merge on login
- [ ] **#16** — Fire domain events (`OrderPlaced`, `OrderStatusChanged`, `OrderCancelled`) from `OrderService`; move all `notify()` and `Mail::queue()` calls into dedicated Listeners
- [ ] **#17** — Extend Spatie activity logging to capture `causer_id`, and `from`/`to` status values on every state transition

#### F. Background Jobs

- [ ] **#14** — `ExpirePendingOrdersJob` — cancel + restore stock for orders that remain `Pending` (no payment) after 30 minutes; schedule every 5 minutes
- [ ] **#15** — `PurgeAbandonedCartsJob` — delete carts older than 7 days with no associated order; schedule daily

---

### Frontend (Vue SPA changes required by payment flow)

- [ ] Remove the direct `POST /api/v1/orders` call from `CheckoutPage.vue`; replace with a two-step flow:
  1. `POST /api/v1/orders/intent` → receive `client_key`
  2. Render PayMongo JS SDK payment form with the `client_key`
  3. On PayMongo JS callback success → redirect to `/checkout/success?order_id=...`
- [ ] `CheckoutSuccess.vue` — poll `GET /api/v1/orders/{id}` until status is not `Pending` (max 30s); show loading state while waiting for webhook to confirm
- [ ] Add toast on successful cart add showing item name and quantity
- [ ] Handle `409 Conflict` from the idempotency lock (show "Order already in progress" message)
- [ ] Expose store owner order management actions in the Filament Store panel sidebar (Filament pages, not Vue SPA — see Filament notes below)

---

## API Contract

### New / Changed Endpoints

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| `POST` | `/api/v1/orders/intent` | ✅ Sanctum | Create PayMongo payment intent; returns `client_key` |
| `POST` | `/api/v1/orders` | ✅ Sanctum | Place order (only after payment intent created) |
| `PATCH` | `/api/v1/orders/{order}/confirm` | ✅ Store Owner | Confirm a pending order |
| `PATCH` | `/api/v1/orders/{order}/prepare` | ✅ Store Owner | Mark order as preparing |
| `PATCH` | `/api/v1/orders/{order}/ready` | ✅ Store Owner | Mark order as ready for pickup |
| `PATCH` | `/api/v1/orders/{order}/deliver` | ✅ Store Owner | Mark order as delivered |
| `POST` | `/webhooks/paymongo` | ⚠️ HMAC signed | Payment gateway webhook |

### `POST /api/v1/orders/intent` — Request

```json
{
  "store_id": 3
}
```

### `POST /api/v1/orders/intent` — Response `201`

```json
{
  "order_id": 42,
  "payment_intent_id": "pi_abc123",
  "client_key": "pi_abc123_client_secret_xyz"
}
```

### `POST /webhooks/paymongo` — Handled Events

| Event | Action |
|---|---|
| `payment.paid` | `OrderService::confirm($order)` → notify customer |
| `payment.failed` | `OrderService::markPaymentFailed($order)` → restore stock, notify customer |

---

## Order State Machine (updated)

```
                     ┌──────────────────┐
              ┌─────▶│  PaymentFailed   │
              │      └──────────────────┘
[Created] → Pending ─┼──(webhook: paid)──▶ Confirmed → Preparing → Ready → Delivered
              │
              └──────────────────────────────────────────────▶ Cancelled
                                                   (customer: Pending only;
                                                    store owner: any active status)
Cancelled / Delivered ──▶ RefundPending ──(gateway confirms)──▶ Refunded
```

### Transition Matrix

| From → To | Who can trigger |
|---|---|
| `Pending → Confirmed` | PayMongo webhook (`payment.paid`) |
| `Pending → PaymentFailed` | PayMongo webhook (`payment.failed`) |
| `Pending → Cancelled` | Customer, Admin |
| `Confirmed → Preparing` | Store Owner, Admin |
| `Confirmed → Cancelled` | Store Owner, Admin |
| `Preparing → Ready` | Store Owner, Admin |
| `Ready → Delivered` | Store Owner, Admin |
| `Delivered → RefundPending` | Admin |
| `Cancelled → RefundPending` | Admin (if payment was collected) |
| `RefundPending → Refunded` | PayMongo webhook (`refund.updated`) |

---

## Database Changes

### Migration: `add_payment_columns_to_lunar_orders_table`

| Column | Type | Description |
|---|---|---|
| `payment_intent_id` | `string, nullable` | PayMongo payment intent ID |
| `payment_status` | `string, nullable` | Raw status from gateway (`awaiting_payment`, `paid`, `failed`) |
| `paid_at` | `timestamp, nullable` | When payment was confirmed by webhook |
| `cancelled_at` | `timestamp, nullable` | When order was cancelled |

### Migration: `create_idempotency_keys_table` _(optional — Redis can replace this)_

| Column | Type | Description |
|---|---|---|
| `key` | `string, unique` | Client-supplied `X-Idempotency-Key` |
| `user_id` | `foreignId` | Owner of the key |
| `response_status` | `smallint` | HTTP status of the cached response |
| `response_body` | `json` | Full response body to replay |
| `expires_at` | `timestamp` | 24h from creation |

---

## Events & Listeners

| Event | Listener | Action |
|---|---|---|
| `OrderPlaced` | `NotifyStoreOwnerOfNewOrder` | Queue `NewOrderReceived` mail + `OrderPlacedNotification` |
| `OrderStatusChanged` | `NotifyCustomerOfStatusChange` | Queue `OrderStatusUpdated` notification |
| `OrderStatusChanged` | `RecordOrderAuditTrail` | Log `from`/`to` status + causer to activity log |
| `OrderCancelled` | `RestoreOrderStock` | Restore `ProductVariant::stock` for each line |
| `OrderCancelled` | `NotifyCustomerOfStatusChange` | (same listener, different event source) |
| `PaymentFailed` | `RestoreOrderStock` | Same as cancellation stock restore |
| `PaymentFailed` | `NotifyCustomerOfPaymentFailure` | Dedicated mail explaining next steps |

---

## Jobs

| Job | Schedule | Description |
|---|---|---|
| `ExpirePendingOrdersJob` | Every 5 min | Cancel orders stuck in `Pending` for > 30 min, restore stock |
| `PurgeAbandonedCartsJob` | Daily 02:00 | Delete `lunar_carts` older than 7 days with no linked order |

---

## Tests to Write

### Feature (Pest)

- [ ] `POST /orders/intent` returns `payment_intent_id` and `client_key`
- [ ] `POST /orders/intent` with empty cart returns 422
- [ ] `POST /orders/intent` with unapproved store returns 422
- [ ] `POST /orders` without prior payment intent returns 422
- [ ] `POST /orders` with out-of-stock variant returns 422
- [ ] Concurrent `POST /orders` returns 409 for the second request (lock test)
- [ ] `POST /webhooks/paymongo` with valid signature + `payment.paid` → order status is `confirmed`
- [ ] `POST /webhooks/paymongo` with invalid signature → 401
- [ ] `POST /webhooks/paymongo` with `payment.failed` → stock restored, order is `payment_failed`
- [ ] `PATCH /orders/{id}/confirm` by store owner → 200; by customer → 403
- [ ] `PATCH /orders/{id}/cancel` by customer when `Pending` → 200
- [ ] `PATCH /orders/{id}/cancel` by customer when `Confirmed` → 403
- [ ] `ExpirePendingOrdersJob` cancels orders older than 30 min and restores stock
- [ ] Commission calculation: integer arithmetic produces correct result for float rates (e.g. 7.5%)

### Unit (Pest)

- [ ] `OrderStatus::canTransitionTo()` matrix — all valid/invalid combinations
- [ ] `CommissionService::calculate()` — no float drift at boundary values
- [ ] `OrderStatus::active()` — does not include `Delivered`, `Cancelled`, `PaymentFailed`, `Refunded`

---

## Filament Panel Notes

The store owner order management UI already lives in the Filament Store panel (`ScopedOrderResource`).
The new API endpoints mirror the same actions for programmatic / mobile access.
No Filament changes are needed for this phase unless the `PaymentFailed` and `Refunded` statuses
need to be added to the Filament badge color map (`OrderStatus::color()`).

---

## Non-Goals for This Phase

- Rider / delivery assignment system (Phase 6)
- Stripe Connect payouts and commission disbursement (Phase 6)
- Multi-currency support
- Promo codes / discount engine
- Subscription billing
