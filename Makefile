# Makefile — Multi-Restaurant Marketplace
# Usage: make <target>
# Run `make help` to see all available commands.

# --------------------------------------------------------------------------
# Configuration
# --------------------------------------------------------------------------

# Use both compose files: base + dev override. For prod-only: make up ENV=prod
ENV ?= dev
ifeq ($(ENV),prod)
  DC = docker compose -f docker-compose.yml
else
  DC = docker compose -f docker-compose.yml -f docker-compose.dev.yml
endif
APP         = $(DC) exec app
NODE        = $(DC) exec node
DB          = $(DC) exec db

# --------------------------------------------------------------------------
# Docker / Lifecycle
# --------------------------------------------------------------------------

.PHONY: build up down restart ps logs

## Build all Docker images
build:
	$(DC) build

## Start all containers in detached mode
up:
	$(DC) up -d

## Stop and remove all containers
down:
	$(DC) down

## Restart all containers
restart: down up

## Show running containers
ps:
	$(DC) ps

## Tail logs for all services (Ctrl-C to stop)
logs:
	$(DC) logs -f

# --------------------------------------------------------------------------
# First-time Setup
# --------------------------------------------------------------------------

.PHONY: setup install

## Full first-time project setup (build, start, install deps, migrate, seed)
setup: build up install key migrate seed npm-install npm-build
	@echo ""
	@echo "✅  Setup complete!"
	@echo "    App  → http://localhost:8080"
	@echo "    Mail → http://localhost:8025  (MailHog)"
	@echo "    Vite → http://localhost:5173  (npm run dev)"
	@echo ""

## Install PHP dependencies inside the app container
install:
	$(APP) composer install

## Copy .env.example → .env if .env does not exist
env:
	$(APP) cp -n .env.example .env || true

## Generate Laravel application key
key:
	$(APP) php artisan key:generate

# --------------------------------------------------------------------------
# Database
# --------------------------------------------------------------------------

.PHONY: migrate migrate-fresh seed db-shell

## Run database migrations
migrate:
	$(APP) php artisan migrate --no-interaction

## Drop all tables and re-run migrations
migrate-fresh:
	$(APP) php artisan migrate:fresh --no-interaction

## Seed the database
seed:
	$(APP) php artisan db:seed --no-interaction

## Open an interactive psql shell
db-shell:
	$(DB) psql -U laravel marketplace

# --------------------------------------------------------------------------
# Frontend / Vite
# --------------------------------------------------------------------------

.PHONY: npm-install npm-dev npm-build

## Install Node dependencies
npm-install:
	$(NODE) npm install

## Start Vite dev server (HMR)
npm-dev:
	$(NODE) npm run dev -- --host

## Build frontend assets for production
npm-build:
	$(NODE) npm run build

# --------------------------------------------------------------------------
# Artisan Helpers
# --------------------------------------------------------------------------

.PHONY: artisan tinker queue cache-clear optimize

## Run any artisan command — usage: make artisan CMD="make:model Foo"
artisan:
	$(APP) php artisan $(CMD)

## Open Laravel Tinker REPL
tinker:
	$(APP) php artisan tinker

## Start the queue worker
queue:
	$(APP) php artisan queue:work --no-interaction

## Clear all caches
cache-clear:
	$(APP) php artisan config:clear
	$(APP) php artisan cache:clear
	$(APP) php artisan route:clear
	$(APP) php artisan view:clear

## Cache config, routes, and views for production
optimize:
	$(APP) php artisan optimize

# --------------------------------------------------------------------------
# Testing & Quality
# --------------------------------------------------------------------------

.PHONY: test test-filter lint pint

## Run the full test suite (Pest)
test:
	$(APP) php artisan test --compact

## Run tests matching a filter — usage: make test-filter FILTER="OrderPlacement"
test-filter:
	$(APP) php artisan test --compact --filter=$(FILTER)

## Run Dusk browser tests (requires selenium container)
dusk:
	$(APP) php artisan dusk

## Run Dusk tests matching a filter — usage: make dusk-filter FILTER="admin can log in"
dusk-filter:
	$(APP) php artisan dusk --filter="$(FILTER)"

## Run Laravel Pint code formatter
pint:
	$(APP) vendor/bin/pint --format agent

## Run Pint on changed files only
pint-dirty:
	$(APP) vendor/bin/pint --dirty --format agent

# --------------------------------------------------------------------------
# Shell Access
# --------------------------------------------------------------------------

.PHONY: shell shell-node

## Open a bash shell inside the app container
shell:
	$(DC) exec app bash

## Open a shell inside the node container
shell-node:
	$(DC) exec node sh

# --------------------------------------------------------------------------
# Help
# --------------------------------------------------------------------------

.PHONY: help

## Show this help message
help:
	@echo ""
	@echo "Multi-Restaurant Marketplace — Make Targets"
	@echo "============================================"
	@echo ""
	@grep -E '^## ' Makefile | sed 's/^## /  /' | while IFS= read -r line; do echo "$$line"; done
	@echo ""
	@echo "Usage: make <target>"
	@echo ""
