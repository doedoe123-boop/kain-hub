# Customer Agent

**Purpose:** Enhance customer experience.

**Tasks:**

- Suggest popular items based on store or order history.
- Notify customers of order status updates.
- Recommend alternative stores if cart is empty.
- Optionally, handle customer support queries.

**Key Files:**

- Model: `app/Models/User.php` (with UserRole enum)
- Livewire Login: `app/Livewire/Auth/Login.php`
- Livewire Register: `app/Livewire/Auth/Register.php`
- Tests: `tests/Feature/AuthenticationTest.php`

**Phase 1 (Auth Foundation) - COMPLETED:**

- Customer registration (defaults to `customer` role)
- Login/logout via Livewire components
- Guest layout for auth pages, app layout with nav for authenticated pages
- Welcome page with role-aware navigation

**Phase 4 (Customer Storefront) - PLANNED:**

- Browse stores and products
- Add items to cart (single-store restriction)
- Checkout and place orders
- Order history and tracking

**Prompt Example:**
