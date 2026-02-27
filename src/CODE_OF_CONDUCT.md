# Code of Conduct & Development Standards

This document defines the coding standards, architectural principles, and development guidelines for the **Multi-Restaurant Marketplace** project.

---

## PSR-12 Coding Standard

This project follows **[PSR-12: Extended Coding Style](https://www.php-fig.org/psr/psr-12/)** enforced via [Laravel Pint](https://laravel.com/docs/pint).

### Key Rules

- **Indentation:** 4 spaces (no tabs).
- **Line length:** Soft limit of 120 characters.
- **Braces:** Opening brace on the same line for control structures, next line for classes/methods.
- **Imports:** Ordered alphabetically, one per line, no unused imports.
- **Visibility:** Always declare visibility on properties and methods.
- **Type declarations:** Use strict parameter and return types.
- **Trailing commas:** Use in multi-line arrays and function parameters.

### Enforcement

Run `docker compose exec app ./vendor/bin/pint` before committing. Use `--dirty` to check only changed files or `--test` for a dry run.

---

## SOLID Principles

All code in this project must follow SOLID principles:

### S — Single Responsibility Principle

Each class should have **one reason to change**.

| Layer             | Responsibility                                                                   |
| ----------------- | -------------------------------------------------------------------------------- |
| **Controllers**   | Accept HTTP requests, delegate to services, return responses. No business logic. |
| **Form Requests** | Input validation and authorization.                                              |
| **Services**      | Business logic (e.g., `CommissionService`, `OrderService`).                      |
| **Models**        | Data access, relationships, scopes, casts. No HTTP or presentation logic.        |
| **Policies**      | Authorization rules per model.                                                   |
| **Enums**         | Named constants with behavior (e.g., `UserRole`, `StoreStatus`, `OrderStatus`).  |

### O — Open/Closed Principle

Classes should be **open for extension, closed for modification**.

- Use PHP enums with methods instead of switch statements scattered across the codebase.
- Use Laravel's pipeline pattern and middleware for extensible request handling.
- Prefer strategy/policy patterns over conditionals.

### L — Liskov Substitution Principle

Subtypes must be substitutable for their base types.

- Extended Lunar models (e.g., `App\Models\Order extends Lunar\Models\Order`) must honor the parent contract.
- Factory states must produce valid model instances.
- Custom implementations of interfaces must fulfill the full contract.

### I — Interface Segregation Principle

Clients should not be forced to depend on methods they don't use.

- Keep service interfaces focused (e.g., `CommissionCalculator` vs. `OrderProcessor`).
- Use Laravel contracts where appropriate.
- Filament resources only implement the methods they need.

### D — Dependency Inversion Principle

Depend on abstractions, not concretions.

- Inject services via constructor or method injection.
- Use Laravel's service container for binding.
- Never instantiate services directly in controllers.

---

## Architectural Guidelines

### Multi-Store Isolation

- All store-scoped queries **must** filter by `store_id`.
- Use global scopes or explicit query scoping — never trust implicit filtering.
- Staff and store owners only see data belonging to their store.

### Naming Conventions

| Type          | Convention                 | Example                         |
| ------------- | -------------------------- | ------------------------------- |
| Models        | Singular PascalCase        | `Store`, `Order`, `ProductType` |
| Controllers   | PascalCase + `Controller`  | `OrderController`               |
| Services      | PascalCase + `Service`     | `CommissionService`             |
| Policies      | Model + `Policy`           | `StorePolicy`                   |
| Form Requests | Action + Model + `Request` | `StoreOrderRequest`             |
| Enums         | PascalCase                 | `UserRole`, `OrderStatus`       |
| Migrations    | Snake_case descriptive     | `create_stores_table`           |
| Test files    | PascalCase + `Test`        | `StoreStaffTest`                |
| Routes        | Kebab-case URIs            | `/api/orders/{order}`           |
| Route names   | Dot notation               | `api.orders.store`              |

### Database

- Always use Eloquent relationships over raw joins.
- Use `Model::query()` instead of `DB::` facade.
- Prevent N+1 queries with eager loading.
- Use migrations for all schema changes — never modify the DB directly.

### Testing

- Write **feature tests** for all endpoints and flows.
- Use **factories** with states for test data.
- Tests must be independent — no shared state between tests.
- Run `docker compose exec app php artisan test --compact` before committing.

### Frontend

- Vue 3 Composition API with `<script setup>`.
- Inertia.js for server-driven SPA.
- Tailwind CSS utility-first approach.
- Components in PascalCase.

---

## Code Review Checklist

Before submitting code, verify:

- [ ] Follows PSR-12 (run Pint with `--dirty`)
- [ ] No business logic in controllers
- [ ] Form Request used for validation
- [ ] Store-scoped queries filter by `store_id`
- [ ] Relationships use eager loading where needed
- [ ] Tests written for new functionality
- [ ] All tests pass (`docker compose exec app php artisan test --compact`)
- [ ] No `env()` calls outside config files
- [ ] Named routes used for all links
- [ ] PHPDoc blocks on public methods
