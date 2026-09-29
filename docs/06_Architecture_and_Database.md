# Architecture & Database Design — P002: Small Business Management System

## Architecture

```
User
→ Frontend / server-rendered PHP views
→ PHP backend/business logic
→ MySQL database
```

- **Frontend:** PHP server-rendered views. Lightweight JavaScript may be used only where useful for UX — this project does not use a separate frontend framework.
- **Backend:** PHP. Keep the implementation simple; do not over-engineer.
- **Database:** MySQL.
- **Authentication:** PHP sessions. Passwords use `password_hash()` and `password_verify()`.
- **File storage:** Local filesystem for exports/invoices where required.
- **Backup:** Manual `mysqldump` script or admin-panel export button.
- **Deployment:** Local XAMPP development/demo. Live hosting is optional and outside the current P002 scope.

## Database Design

### Relationship Concept
```
Customer
    |
    └── Sale ──── User
          |
          ├── SaleItem ─── Product
          |
          └── Payment (Should Have)
```

### Core Tables

| Table | Priority |
|---|---|
| `users` | Must Have |
| `products` | Must Have |
| `customers` | Must Have |
| `sales` | Must Have |
| `sale_items` | Must Have |
| `payments` | **Should Have** — tracks paid/unpaid/partial status; not required for the Must-Have sale flow |
| `expenses` | Should Have |

### Important Rules
- `sales.total` is calculated from `sale_items`, not entered directly by the user.
- `sale_items` connects `sales` and `products`.
- `sale_items` stores quantity and price-at-time-of-sale so later product price changes don't rewrite historical sales.
- `sale_items.sale_id → sales.id`
- `sale_items.product_id → products.id`
- `sales.customer_id → customers.id` — **nullable**, since a customer is optional (walk-in sales are valid).
- A sale's payment method (if applicable) may be stored directly on the `sales` record as part of the core Must-Have flow. The separate `payments` table (status tracking over time) is Should-Have only.

Exact column definitions are derived during implementation, not fixed in this document.
