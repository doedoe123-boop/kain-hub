# Security Policy

## Supported Versions

| Version              | Supported |
| -------------------- | --------- |
| Latest (main branch) | ✅ Yes    |
| Older branches       | ❌ No     |

---

## Reporting a Vulnerability

If you discover a security issue in **NegosyoHub**, **do not open a public issue**.  

Please report it responsibly via email to the project maintainers, including:

- Description of the vulnerability  
- Steps to reproduce  
- Potential impact  
- Suggested fix (optional)

We aim to acknowledge reports within **48 hours** and provide a fix or mitigation within **7 days**.

---

## Security Overview

NegosyoHub follows standard security best practices:

- **Authentication & Authorization**  
  - Laravel Sanctum for API tokens  
  - Role-based access using Spatie Laravel Permission  
  - Policies enforce model-level authorization  

- **Input & Data Validation**  
  - Form Request validation for all user input  
  - File uploads validated for type and size  
  - CSRF protection enabled on web routes  

- **Database & Dependencies**  
  - Eloquent ORM prevents SQL injection  
  - Keep dependencies up to date (`composer audit`, `npm audit`)  

- **Environment & Deployment**  
  - `.env` contains sensitive credentials, never committed  
  - Debug mode disabled in production (`APP_DEBUG=false`)  
  - HTTPS enforced  

- **API Security**  
  - Token-based stateless auth  
  - Rate limiting on authentication endpoints  
  - Versioned API routes (`/api/v1/`)  

---

## Additional Recommendations

- Store sensitive files outside public access  
- Serve downloads through authenticated routes  
- Only use trusted packages and review dependencies regularly