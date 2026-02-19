# Multi-Restaurant Marketplace

A multi-restaurant marketplace built with **Laravel 12**, **Lunar PHP**, **Vue 3**, and **PostgreSQL**, running on Docker.

---

## Requirements

- [Docker](https://docs.docker.com/get-docker/) & Docker Compose v2+
- `make` (pre-installed on Linux/macOS; use WSL2 on Windows)

---

## Getting Started

```bash
git clone <your-repo-url> kain-hub
cd kain-hub
cp src/.env.example src/.env
make setup
```

That's it. Open **http://localhost:8080** in your browser.

---

## Docker Commands

```bash
make build       # Build images
make up          # Start containers
make down        # Stop containers
make restart     # Restart containers
make logs        # View logs
make ps          # List containers
```

### Without Make

```bash
# Start
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build

# Stop
docker compose -f docker-compose.yml -f docker-compose.dev.yml down

# Rebuild
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build
```

### Production

```bash
make up ENV=prod
```

---

## URLs

| Service     | URL                         |
| ----------- | --------------------------- |
| App         | http://localhost:8080       |
| Lunar Admin | http://localhost:8080/lunar |
| Vite (HMR)  | http://localhost:5173       |
| MailHog     | http://localhost:8025       |
| PostgreSQL  | localhost:5433              |

---

## Common Commands

```bash
make migrate          # Run migrations
make migrate-fresh    # Drop & re-run migrations
make seed             # Seed database
make test             # Run tests
make pint             # Format code
make shell            # Shell into app container
make tinker           # Laravel Tinker REPL
make artisan CMD="…"  # Run any artisan command
```

### Frontend

```bash
make npm-install      # Install node packages
make npm-dev          # Start Vite dev server
make npm-build        # Build for production
```

### Database

```bash
make db-shell         # Open psql shell
```

---

## Containers

| Container        | Service    | Port |
| ---------------- | ---------- | ---- |
| `laravel_app`    | PHP-FPM    | 9000 |
| `laravel_nginx`  | Nginx      | 8080 |
| `marketplace_db` | PostgreSQL | 5433 |
| `frontend_node`  | Vite       | 5173 |
| `mailhog`        | MailHog    | 8025 |

---

## Project Structure

```
kain-hub/
├── src/                     # Laravel app
│   ├── app/
│   │   ├── Models/          # Eloquent models
│   │   ├── Services/        # Business logic
│   │   ├── Http/            # Controllers, Requests
│   │   └── Policies/        # Authorization
│   ├── database/            # Migrations, factories, seeders
│   ├── routes/              # web.php, api.php
│   └── tests/               # Pest tests
├── docker/
│   ├── php/Dockerfile
│   └── nginx/default.conf
├── docker-compose.yml       # Base config
├── docker-compose.dev.yml   # Dev overrides (node, mailhog)
└── Makefile
```

---

## User Roles

| Role        | Access                                         |
| ----------- | ---------------------------------------------- |
| Admin       | Manage stores, view all orders, set commission |
| Store Owner | Manage own store & products, view own orders   |
| Customer    | Browse stores, place orders                    |

---

## Testing

```bash
make test                               # All tests
make test-filter FILTER="OrderPlacement" # Specific test
```

---

## Resources

- [Laravel](https://laravel.com/docs) · [Lunar PHP](https://lunarphp.com) · [Vue 3](https://vuejs.org) · [Pest](https://pestphp.com) · [PostgreSQL](https://www.postgresql.org/docs)
