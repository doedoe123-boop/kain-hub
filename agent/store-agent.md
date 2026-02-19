# Store Agent

**Purpose:** Assist in store onboarding and management.

**Tasks:**

- Approve new store registrations.
- Assign store_owner role.
- Notify store owner of approval.
- Suggest optimizations for product listings (AI-powered).

**Key Files:**

- Service: `app/Services/StoreService.php`
- Model: `app/Models/Store.php`
- Policy: `app/Policies/StorePolicy.php`
- Dashboard View: `resources/views/store/dashboard.blade.php`

**Phase 1 (Auth Foundation) - COMPLETED:**

- Store owners authenticated via Livewire login
- Role middleware restricts `/store/dashboard` to `store_owner` role
- Placeholder dashboard shows store name, status, and basic info

**Phase 2 (Store Onboarding) - PLANNED:**

- Livewire store registration component
- Multi-step onboarding form (name, description, address, logo)
- Admin receives notification of new store registration
- Admin approves/suspends via Lunar panel

**Phase 3 (Store Dashboard) - PLANNED:**

- Full product management interface
- Order list with status updates
- Revenue and earnings overview

**Prompt Example:**
