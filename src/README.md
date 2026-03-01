# NegosyoHub — Laravel Application

The Laravel 12 backend powering the **NegosyoHub** multi-sector marketplace platform.

---

## Tech Stack

| Layer             | Technology                       |
| ----------------- | -------------------------------- |
| Framework         | Laravel 12 (PHP 8.4)             |
| E-Commerce Engine | Lunar PHP 1.3                    |
| Admin Panels      | Filament v3                      |
| Frontend          | Vue 3 + Inertia.js + Tailwind v4 |
| Database          | PostgreSQL 15                    |
| Testing           | Pest v4 + Laravel Dusk           |
| Code Style        | Laravel Pint                     |

---

## Panels

The platform exposes three Filament admin panels:

| Panel  | Path                  | Users                   |
| ------ | --------------------- | ----------------------- |
| Admin  | `/moon/portal/…`      | Platform administrators |
| Store  | `/store/dashboard/…`  | Store owners & staff    |
| Realty | `/realty/dashboard/…` | Real estate agents      |

### Admin Panel Resources

Stores, Users, Sectors, Orders, Payouts, FAQs, Announcements, Legal Pages, Activity Logs, Login History, Support Tickets.

### Store (Lunar) Panel Resources

Products, Collections, Orders, Staff Members, Reviews, Store Profile, Earnings & Payouts.

### Realty Panel Resources

Properties, Property Inquiries, Developments, Open Houses, Testimonials.

---

## Application Structure

```
app/
├── Console/              # Artisan commands
├── Filament/
│   ├── Admin/            # Admin panel (Resources, Pages, Widgets)
│   ├── Realty/           # Realty panel (Resources, Pages, Widgets)
│   ├── Pages/            # Shared Lunar panel pages
│   ├── Resources/        # Shared Lunar panel resources
│   └── Widgets/          # Shared Lunar panel widgets
├── Http/
│   ├── Controllers/      # HTTP controllers
│   └── Requests/         # Form request validation
├── Jobs/                 # Queued jobs
├── Listeners/            # Event listeners
├── Livewire/             # Livewire components
├── Mail/                 # Mailable classes
├── Models/               # Eloquent models
├── Observers/            # Model observers
├── Policies/             # Authorization policies
├── Providers/            # Service providers
├── Rules/                # Custom validation rules
├── Services/             # Business logic (Commission, Order, Store)
├── IndustrySector.php    # Sector enum
├── OrderStatus.php       # Order status enum
├── StoreStatus.php       # Store status enum
└── UserRole.php          # User role enum
```

---

## Models

`User`, `Store`, `Sector`, `Order`, `Payout`, `Review`, `Announcement`, `Faq`, `LegalPage`, `LoginHistory`, `SupportTicket`, `Property`, `PropertyInquiry`, `PropertyAnalytic`, `Development`, `OpenHouse`, `OpenHouseRsvp`, `Testimonial`, `SavedSearch`, `SectorDocument`.

---

## User Roles

| Role         | Description                                |
| ------------ | ------------------------------------------ |
| Admin        | Platform admin — full system access        |
| Store Owner  | Manages store, products, orders, staff     |
| Staff        | Store staff with limited permissions       |
| Realty Agent | Manages properties, inquiries, open houses |
| Customer     | Browses stores, places orders              |

---

## Services

| Service             | Responsibility                                     |
| ------------------- | -------------------------------------------------- |
| `OrderService`      | Order placement, status transitions, validation    |
| `CommissionService` | Platform commission calculation, payout processing |
| `StoreService`      | Store registration, approval, profile management   |

---

## Testing

### Unit & Feature Tests (Pest)

```bash
# Run all tests
php artisan test --compact

# Run a specific test
php artisan test --compact --filter=OrderPlacement
```

**224 tests, 503 assertions** covering authentication, authorization, order placement, store management, reviews, staff, realty features, API auth, and more.

### Browser Tests (Laravel Dusk)

```bash
# Run all Dusk E2E tests
php artisan dusk

# Run a specific Dusk test
php artisan dusk --filter="admin can log in"
```

**37 browser tests** across all three Filament panels:

- **AdminPanelTest** (17 tests) — login, authorization, all CRUD resources, sidebar navigation
- **StorePanelTest** (10 tests) — owner access, role restrictions, products, orders, staff, earnings
- **RealtyPanelTest** (10 tests) — agent access, role restrictions, properties, inquiries, testimonials

Dusk requires the Selenium container (`selenium/standalone-chromium`) from `docker-compose.dev.yml`.

---

## Key Configuration

- **Multi-tenant filtering** — all store-scoped queries filter by `store_id`
- **JSONB columns** — used for dynamic attributes and flexible data
- **Lunar PHP integration** — products, collections, and orders extend Lunar's base models
- **Spatie permissions** — role-based access for Lunar panel resources

---

## Common Artisan Commands

```bash
php artisan migrate                  # Run migrations
php artisan migrate:fresh --seed     # Fresh database with seeds
php artisan db:seed                  # Seed data
php artisan tinker                   # Interactive REPL
vendor/bin/pint                      # Format code
```

---

## Resources

- [Laravel 12](https://laravel.com/docs) · [Lunar PHP](https://lunarphp.com) · [Filament v3](https://filamentphp.com/docs) · [Pest](https://pestphp.com) · [Laravel Dusk](https://laravel.com/docs/dusk) · [PostgreSQL](https://www.postgresql.org/docs)
