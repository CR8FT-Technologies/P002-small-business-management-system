# Requirements — P002: Small Business Management System

## Functional Requirements

| ID | Requirement | Priority |
|---|---|---|
| FR-001 | User can log in (admin) | Must |
| FR-002 | Admin can add/edit/delete products | Must |
| FR-003 | Admin can add/edit/delete customers | Must |
| FR-004 | User can record a sale | Must |
| FR-005 | System deducts stock after a sale | Must |
| FR-006 | User can generate an invoice from a sale | Must |
| FR-007 | User can view a dashboard summary | Must |
| FR-008 | Data can be backed up/exported | Must |
| FR-009 | User can log expenses | Should |
| FR-010 | User can mark invoices as paid/unpaid/partial | Should |
| FR-011 | User can view sales reports by day/month | Should |
| FR-012 | User can search/filter records | Should |
| FR-013 | Basic staff login with ordinary access | Optional extension (build only if time remains after all Must-Have items) |

## Functional Details

### Authentication
Allows a user to log in before accessing the system.

- **Actor:** Admin (Must Have). Staff is an optional extension (FR-013), not a Must-Have.
- **Inputs:** Username/email, password
- **Processing:** Validate credentials, start authenticated session
- **Output:** Authenticated session; redirect to dashboard
- **Exceptions:** Invalid credentials, empty fields, locked/inactive account

### Product Management
Admin can add, edit, view, and delete products/services.

- **Inputs:** Name, price, quantity/stock, category (optional)
- **Validation:** Required fields; no negative price; no negative quantity; duplicate product names handled appropriately

### Customer Management
Admin can add, edit, view, and delete customers.

- **Inputs:** Name, phone (optional), email (optional), address (optional)
- **Validation:** Name required; duplicate contact information handled appropriately

### Sales Management
Authenticated user can record a sale.

- **Inputs:** Customer (optional), products, quantity. Payment method may be captured as part of the sale record.
- **Processing:** Validate stock, validate quantity, calculate total, save sale, deduct inventory, generate invoice, update sales history
- **Customer rule:** Customer selection is optional. A sale with no customer selected is a valid walk-in/anonymous sale. If a customer *is* selected, it must reference an existing customer record.
- **Exceptions:** Insufficient stock, invalid quantity, missing product, invalid customer reference (only applies if a customer was selected)

> **Note:** Payment method may be captured as part of the sale record (Must-Have, since it belongs to core sale data). Tracking an invoice's paid/unpaid/partial **status** over time is a separate Should-Have feature (FR-010) — see [`02_Scope.md`](02_Scope.md#payment-clarification).

### Invoicing
Generate an invoice from a completed sale.

- **Input:** Sale ID
- **Output:** Viewable/printable invoice
- **Exceptions:** Sale not found; sale already invoiced

### Dashboard
Shows:
- Today's total sales
- Low-stock items/count
- Recent sales

If there is no data, show a proper empty state rather than treating it as an error.

## Non-Functional Requirements

### Security
- Passwords must be hashed — never store plain-text passwords. Use `password_hash()` and `password_verify()`.
- Authenticated sessions should expire after inactivity.
- Server-side validation is mandatory.
- Database access must use prepared statements/parameterized queries. Never concatenate untrusted input into SQL.
- Never expose secrets or credentials in source code. Use `.env` for credentials/configuration.
- `.env` must never be committed. Provide `.env.example` with variable names only.
- Never commit real customer data.
- Backup files remain private/local and must not be committed.

### Performance
Dashboard should load in approximately under 2 seconds with a few hundred sample records. This is a practical target, not an excuse to over-engineer.

### Usability
Core actions such as adding a product and recording a sale should be reachable within approximately 3 clicks from the dashboard.

### Reliability
Normal use should not cause data loss. Sale creation and inventory deduction occur together so partial updates don't leave inconsistent data.

### Maintainability
Organize code by feature/responsibility. Avoid giant single files.
