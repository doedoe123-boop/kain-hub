# Contributing to NegosyoHub

Thank you for your interest in contributing! This guide covers the development setup, coding standards, and pull request process.

---

## Development Setup

### Prerequisites

- Docker & Docker Compose v2+
- `make` (Linux/macOS) or WSL2 (Windows)

### Quick Start

```bash
git clone git@github.com:doedoe123-boop/negosyohub.git
cd negosyohub
make setup
```

This starts all containers, runs migrations, and seeds the database.

---

## Project Layout

| Directory   | What it is                                                 |
| ----------- | ---------------------------------------------------------- |
| `src/`      | Laravel 12 backend (API + Blade/Livewire + Filament admin) |
| `frontend/` | Vue 3 SPA (customer storefront)                            |
| `docker/`   | Docker config (Nginx, PHP)                                 |

---

## Coding Standards

### PHP (Backend)

- **PSR-12** style, enforced by [Laravel Pint](https://laravel.com/docs/pint).
- Always use curly braces for control structures, even single-line bodies.
- Use PHP 8.4 constructor property promotion.
- Explicit return type declarations on all methods.
- PHPDoc blocks with array shape type definitions where appropriate.
- Never use `env()` outside of `config/` files — use `config('key')`.
- Never use `DB::` — use `Model::query()` and Eloquent relationships.
- Always eager-load relationships to prevent N+1 queries.
- All validation must go in Form Request classes, never inline in controllers.
- Enums use TitleCase keys.

### JavaScript / Vue (Frontend)

- Vue 3 Composition API with `<script setup>`.
- Pinia for state management.
- All API calls go through `src/api/` modules using the `/api/v1/` prefix.

---

## Making Changes

### Branch Naming

Use descriptive branch names:

```
feature/add-store-reviews
fix/order-status-display
refactor/commission-service
```

### Before Committing

Run the full validation checklist:

```bash
# 1. Fix PHP code style
cd src && ./vendor/bin/pint --dirty --format agent

# 2. Run backend tests
cd src && php artisan test --compact

# 3. Build Laravel Vite assets (if Blade/Livewire views changed)
cd src && npm run build

# 4. Build frontend (if Vue SPA changed)
cd frontend && npm run build
```

All four checks must pass before submitting a PR.

### Creating Tests

- Use **Pest v4** for all backend tests.
- Create tests with `php artisan make:test --pest {Name}`.
- Feature tests use the `RefreshDatabase` trait (SQLite in-memory).
- Use model factories — check for existing factory states before manual setup.
- New models must include a factory and seeder.

### Creating Models

Always create the factory and seeder alongside the model:

```bash
cd src && php artisan make:model MyModel -mfs --no-interaction
```

---

## Pull Request Process

1. Fork the repository and create a feature branch from `main`.
2. Make your changes following the coding standards above.
3. Run the full validation checklist (Pint, tests, builds).
4. Write or update tests for your changes.
5. Submit a PR against `main` with a clear description of what and why.

### PR Requirements

- All CI checks must pass (Pint style check + Pest tests).
- Keep PRs focused — one feature or fix per PR.
- Include screenshots for UI changes.

---

## CI Pipeline

The CI pipeline (`.github/workflows/php.yml`) runs on every push/PR to `main`:

1. `composer install`
2. Environment setup + `php artisan migrate`
3. `npm ci && npm run build` (Laravel Vite assets)
4. `./vendor/bin/pint --test` (code style)
5. `php artisan test --compact` (backend tests)

All steps must pass for the PR to be mergeable.

---

## Reporting Issues

- Use GitHub Issues for bug reports and feature requests.
- For security vulnerabilities, see [SECURITY.md](SECURITY.md).

---

## License

By contributing, you agree that your contributions will be licensed under the [Apache License 2.0](LICENSE).
