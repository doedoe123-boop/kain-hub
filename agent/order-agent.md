# Order Agent

**Purpose:** AI-assisted order management.

**Tasks:**

- Validate incoming orders (cart non-empty, single-store, store approved).
- Apply commission and calculate store earning via `CommissionService`.
- Trigger notifications for store owners on new orders.
- Suggest upsells to customers (optional future feature).

**Workflow:**

1. Customer submits `POST /api/orders` with `store_id`.
2. `PlaceOrderRequest` validates input and store approval status.
3. `OrderController::store()` retrieves the Lunar cart session.
4. `OrderService::createFromCart()` validates cart, store, and tenant isolation.
5. Lunar creates the order; commission is applied within a DB transaction.
6. Response includes order details and summary with commission breakdown.

**Relevant Skills:**

- `/skills/order-processing.md` – full validation and processing steps.
- `/skills/commission-calculation.md` – earnings breakdown logic.

**Key Files:**

- `app/Services/OrderService.php`
- `app/Services/CommissionService.php`
- `app/Http/Controllers/OrderController.php`
- `app/Http/Requests/PlaceOrderRequest.php`
- `app/Policies/OrderPolicy.php`

**Docker context:** Run inside `laravel_app` container.

**Prompt Example for AI:**
