# CR8FT Technologies — P002: Small Business Management System

A reusable, controlled small-business management prototype built by CR8FT Technologies.
**This is NOT an enterprise ERP** — scope is deliberately limited to a working core that can later be customized per client.

**Status:** 🚧 In development — Must-Have features not yet complete. This README is updated as features ship.

## Purpose
Small businesses often manage products, customers, sales, expenses, and payments through disconnected, manual processes. P002 provides a single, controlled system covering the core of that workflow, built as a reusable base for future CR8FT client engagements.

## Feature Overview
| Feature | Priority | Status |
|---|---|---|
| Admin login/authentication | Must Have | Planned |
| Products (CRUD) | Must Have | Planned |
| Customers (CRUD) | Must Have | Planned |
| Sales (incl. payment method at point of sale) | Must Have | Planned |
| Inventory deduction on sale | Must Have | Planned |
| Invoicing | Must Have | Planned |
| Dashboard | Must Have | Planned |
| Backup/export | Must Have | Planned |
| Basic staff login (only if time remains) | Optional extension | Not started |
| Expenses | Should Have | Not started |
| Payment status tracking (paid/unpaid/partial) | Should Have | Not started |
| Sales reports (daily/monthly) | Should Have | Not started |
| Search/filter | Should Have | Not started |
| Granular role-based permissions | Could Have | Not started |

Full breakdown: see [`docs/02_Scope.md`](docs/02_Scope.md).

## Core Workflow
```
Login → Add Product → Record Sale → Generate Invoice → Dashboard Updates
```
See [`docs/05_Workflows.md`](docs/05_Workflows.md) for all flows.

## Technology Stack
PHP (server-rendered views) · MySQL · PHP Sessions · Git/GitHub · Local XAMPP for development

Full details: [`docs/07_Technology_Stack.md`](docs/07_Technology_Stack.md).

## Documentation
- [Project Overview](docs/01_Project_Overview.md)
- [Scope](docs/02_Scope.md)
- [Requirements](docs/03_Requirements.md)
- [User Stories](docs/04_User_Stories.md)
- [Workflows](docs/05_Workflows.md)
- [Architecture & Database](docs/06_Architecture_and_Database.md)
- [Technology Stack](docs/07_Technology_Stack.md)
- [Task Backlog & Definition of Done](docs/08_Task_Backlog_and_DoD.md)

## Security Notes
- Passwords hashed with `password_hash()`/`password_verify()` — never stored in plain text.
- All database access uses prepared statements/parameterized queries.
- Credentials live in `.env` (never committed) — see `.env.example`.
- No real customer data is ever committed to this repository.
- Backup files stay local/private and are never committed.

## Setup
*(Placeholder — installation steps for local XAMPP will be added once implementation begins.)*

## Testing
*(Placeholder — manual test checklist and results will be documented here as features are completed.)*

## Screenshots
*(Placeholder — added once the UI exists.)*

## Deployment
Local XAMPP is the current development and submission environment for P002. Live hosting/a public demo link is optional and outside the current scope.

## Future Customization
P002 is designed to be a reusable base. Future CR8FT client engagements can fork/extend this system rather than building a business-management tool from scratch.

## Team
CR8FT Technologies — Amit Kunwar (Overall Head & Technical Lead)
