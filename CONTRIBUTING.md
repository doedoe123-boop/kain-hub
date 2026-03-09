# Contributing to NegosyoHub

Thank you for your interest in contributing to **NegosyoHub**!  
This guide explains how to report issues, submit pull requests, and set up the project locally.

---

## Issues

- Check existing issues first to avoid duplicates.  
- Clearly state whether it’s a bug, feature request, question, or general feedback.  
- Include relevant details: steps to reproduce, expected vs actual behavior, logs, and screenshots if helpful.  
- Use our [issue templates](.github/ISSUE_TEMPLATE/) when available.

---

## Pull Request Process

1. Fork the repository and create a feature branch from `main`.  
2. Open an Issue first (unless fixing a trivial documentation typo).  
3. Make your changes following the coding standards.  
4. Run the validation checklist (see below).  
5. Write or update tests for your changes.  
6. Submit a PR against `main` with a clear description linking the Issue.  

### PR Guidelines

- Keep PRs **focused on a single change** (feature, fix, or refactor).  
- Use descriptive titles like `fix/order-status-display` or `feature/add-store-reviews`.  
- Include before/after screenshots for UI changes.  
- PRs that include tests are more likely to be accepted.  
- Discussions should be marked resolved after addressing comments.  
- Do not modify `LICENSE`, `SECURITY.md`, or `CONTRIBUTING.md` from outside the core team.

---

## Development Setup

### Branching

NegosyoHub uses a simple branching workflow:

- **main**  
  - Production-ready, stable code only.  
  - PRs to `main` are rare and usually come from `develop` after testing.

- **develop**  
  - Active development branch.  
  - Features, fixes, and refactors are merged here first.  
  - CI runs on `develop` to verify integration.

- **Feature / Fix branches**  
  - Always create feature branches from `develop`:  
    ```bash
    git checkout develop
    git checkout -b feature/add-store-reviews
    ```  
  - Submit PRs targeting `develop`.

- **Release / Hotfix branches (optional)**  
  - Create a release branch from `develop` when preparing a production release.  
  - Hotfixes for `main` go directly to `main` and are merged back into `develop`.

### Prerequisites

- Docker & Docker Compose v2+  
- `make` (Linux/macOS) or WSL2 (Windows)

### Quick Start

```bash
git clone git@github.com:doedoe123-boop/negosyohub.git
cd negosyohub
make setup
```


