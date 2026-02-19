# Commission Calculation Skill

**Purpose:** Calculate platform and store earnings for orders.

**Inputs:**

- `order_total` (integer, in smallest currency unit e.g. cents)
- `store_commission_rate` (decimal percentage, e.g., 15.00)

**Logic:**

```php
$commission = (int) round($order_total * ($store_commission_rate / 100));
$store_earning = $order_total - $commission;
$platform_earning = $commission;
```

**Edge Cases:**

- `commission_rate = 0` → store keeps 100% of the order total.
- `commission_rate = 100` → platform keeps 100%.
- Fractional results are rounded to nearest integer (`round()`).

**Key Files:**

- Service: `app/Services/CommissionService.php`
- Tests: `tests/Feature/OrderPlacementTest.php` (Commission Calculation describe block)

**Integration:**

- `CommissionService::applyToOrder()` is called inside `OrderService::createFromCart()` within a DB transaction.
- The breakdown is stored on the `lunar_orders` table via `commission_amount`, `store_earning`, and `platform_earning` columns.
