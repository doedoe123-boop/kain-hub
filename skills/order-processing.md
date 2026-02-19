# Order Processing Skill

**Purpose:** Ensure orders are validated and processed correctly.

**Steps:**

1. Verify customer cart is not empty.
2. Ensure cart contains items from **only one store** (tenant isolation).
3. Verify the target store has `status = approved`.
4. Calculate subtotal and apply taxes if any (via Lunar cart calculation).
5. Apply commission logic (see `commission-calculation.md`).
6. Mark order as `pending` and store in database within a transaction.
7. Trigger notifications to store owner.

**Validation Layers:**

- **FormRequest** (`PlaceOrderRequest`) – validates `store_id` exists and store is approved.
- **Service** (`OrderService`) – validates cart is non-empty, items belong to one store, and store is approved before creating the order.

**Key Files:**

- Service: `app/Services/OrderService.php`
- Controller: `app/Http/Controllers/OrderController.php`
- FormRequest: `app/Http/Requests/PlaceOrderRequest.php`
- Policy: `app/Policies/OrderPolicy.php`
- Model: `app/Models/Order.php` (extends Lunar's Order)
- Tests: `tests/Feature/OrderPlacementTest.php`

**Commission:** Calculated via `CommissionService` and applied to the order within the same DB transaction. See `commission-calculation.md`.

**Docker context:** All artisan commands for migrations and tests run inside the `laravel_app` container:

```bash
docker exec -it laravel_app php artisan migrate
docker exec -it laravel_app php artisan test --filter=OrderPlacement
```

**Notes:** Use PostgreSQL transactions to ensure consistency.
