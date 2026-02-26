# Security Policy

## Supported Versions

| Version              | Supported |
| -------------------- | --------- |
| Latest (main branch) | ✅        |
| Older branches       | ❌        |

---

## Reporting a Vulnerability

If you discover a security vulnerability in this project, please report it responsibly.

**Do NOT open a public issue.** Instead, email the details to the project maintainer.

Include:

- Description of the vulnerability.
- Steps to reproduce.
- Potential impact.
- Suggested fix (if any).

We aim to acknowledge reports within **48 hours** and provide a fix or mitigation within **7 days**.

---

## Security Practices

### Authentication & Authorization

- **Sanctum** for API token authentication (customer-facing SPA).
- **Filament panel guards** for store owner and admin access.
- **Spatie laravel-permission** for role-based access control (admin, store_owner, staff, customer).
- **Policies** enforce model-level authorization.
- Passwords are hashed using bcrypt (Laravel default).

### Multi-Tenant Data Isolation

- All store-scoped data **must** be filtered by `store_id`.
- Store owners and staff can only access data belonging to their store.
- Admin has platform-wide access.
- Subdomain routing validates store existence and status before granting access.
- Suspended stores are blocked from login.

### Input Validation

- All user input is validated via **Form Request** classes.
- File uploads (KYC documents) are validated for type, size, and stored outside the public directory.
- Philippine ID numbers are validated against known format patterns.

### Session & Cookie Security

- Sessions stored in the database (`SESSION_DRIVER=database`).
- `SESSION_DOMAIN=null` for subdomain cookie isolation.
- CSRF protection enabled on all web routes.
- API routes use token-based auth (no cookies).

### Environment & Configuration

- **Never** use `env()` outside of `config/` files.
- Sensitive credentials stored in `.env` (never committed).
- `.env.example` contains only placeholder values.
- Debug mode disabled in production (`APP_DEBUG=false`).

### Database Security

- All queries use Eloquent ORM or query builder (parameterized).
- No raw SQL without parameter binding.
- Foreign key constraints enforce referential integrity.
- Soft deletes where appropriate to prevent data loss.

### File Upload Security

- KYC documents stored on the `local` disk (not publicly accessible).
- Downloads served through authenticated routes with role checks.
- Only whitelisted fields (`business_permit`) are downloadable.
- File type validation on upload.

### API Security

- Rate limiting on authentication endpoints.
- Token-based auth with Sanctum (no session state).
- API resources control response shape (no model leaks).
- Versioned API routes for backward compatibility.

---

## Dependencies

- Keep dependencies up to date: `composer update` and `npm update`.
- Review `composer audit` and `npm audit` regularly.
- Only use well-maintained, trusted packages.

---

## Deployment Checklist

- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] HTTPS enforced
- [ ] `.env` not accessible publicly
- [ ] `storage/` and `bootstrap/cache/` are writable
- [ ] Database credentials use least-privilege accounts
- [ ] CORS configured for allowed origins only
- [ ] Rate limiting enabled
- [ ] Logging configured (not to stdout in production)
- [ ] Queue workers running with proper restart policies
