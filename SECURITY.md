# Security Policy

## Supported Versions

| Version              | Supported |
| -------------------- | --------- |
| Latest (main branch) | Yes       |
| Older branches       | No        |

## Reporting a Vulnerability

If you discover a security vulnerability in NegosyoHub, **please do not open a public issue**.

Instead, report it responsibly by emailing the project maintainer with:

- A description of the vulnerability
- Steps to reproduce
- Potential impact
- Suggested fix (if any)

We aim to acknowledge reports within **48 hours** and provide a fix or mitigation within **7 days**.

## Security Practices

### Authentication & Authorization

- **Laravel Sanctum** for API token authentication (customer-facing SPA).
- **Filament panel guards** for store owner and admin access.
- **Spatie laravel-permission** for role-based access control (admin, store_owner, staff, customer).
- **Policies** enforce model-level authorization.
- Passwords are hashed using bcrypt (Laravel default).
- Login history is recorded for all authentication attempts (success and failure).

### Multi-Tenant Data Isolation

- All store-scoped data is filtered by `store_id`.
- Store owners and staff can only access data belonging to their store.
- Admin has platform-wide access.
- Subdomain routing validates store existence and status before granting access.
- Suspended stores are blocked from login.

### Input Validation

- All user input is validated via **Form Request** classes — never inline.
- File uploads are validated for type and size, stored outside the public directory.
- CSRF protection enabled on all web routes.
- API routes use token-based auth (no session cookies).

### Database Security

- All queries use Eloquent ORM (parameterized by default).
- No raw SQL without parameter binding.
- Foreign key constraints enforce referential integrity.
- Soft deletes used where appropriate to prevent data loss.

### Environment & Configuration

- `env()` is never used outside of `config/` files.
- Sensitive credentials stored in `.env` (never committed to version control).
- `.env.example` contains only placeholder values.
- Debug mode disabled in production (`APP_DEBUG=false`).

### API Security

- Rate limiting on authentication endpoints.
- Token-based auth with Sanctum (stateless).
- Eloquent API Resources control response shape (no raw model leaks).
- Versioned API routes (`/api/v1/`) for backward compatibility.

### File Upload Security

- Documents stored on the `local` disk (not publicly accessible).
- Downloads served through authenticated routes with role checks.
- File type and size validation on upload.

## Dependencies

- Keep dependencies up to date: `composer update` and `npm update`.
- Review `composer audit` and `npm audit` regularly.
- Only use well-maintained, trusted packages.

## Deployment Checklist

- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] HTTPS enforced
- [ ] `.env` not accessible publicly
- [ ] `storage/` and `bootstrap/cache/` are writable
- [ ] Database credentials use least-privilege accounts
- [ ] CORS configured for allowed origins only
- [ ] Rate limiting enabled
- [ ] Queue workers running with proper restart policies
