# Scope — P002: Small Business Management System

## Must Have — build first, in this order

1. **Admin login/authentication**
2. **Products/services** — Create, Read, Update, Delete
3. **Customers** — Create, Read, Update, Delete
4. **Sales**
   - Select products, enter quantities, automatically calculate total
   - Customer selection is optional (see [`03_Requirements.md`](03_Requirements.md) for the walk-in sale rule)
   - Payment method may be captured as part of the sale record (see Payment Clarification below)
5. **Basic inventory** — stock decreases after a sale
6. **Invoices** — generate invoice from a sale
7. **Dashboard** — today's sales total, low-stock count, recent sales list
8. **Database backup/export** — a simple `mysqldump` or CSV export is sufficient

## Optional Extension (build only after all Must-Have items above work end-to-end)

- **Basic staff login** with ordinary access (same permissions as admin). This is *not* a conditional Must-Have — it is an optional extension, attempted only if time remains.

## Should Have

Only after all Must-Have items work end-to-end:

- Expenses
- **Payment status tracking** (paid/unpaid/partial) — see Payment Clarification below
- Daily/monthly sales reports
- Search/filter

## Could Have

Only if everything above is already complete:

- **Granular role-based permissions** (distinct from basic staff login above)
- Discounts
- Tax fields
- Additional responsive/mobile polishing beyond a usable laptop interface

## Out of Scope

Do not build:

- Multi-branch/multi-location support
- Supplier/purchase-order management
- Accounting/ledger features
- Enterprise ERP functionality

## Payment Clarification

Two distinct things are involved, at two different priorities:

| Item | Priority | Description |
|---|---|---|
| Payment method on a sale | Part of Must-Have Sales (core process) | The sale record may capture how the customer paid (e.g. cash, card), if applicable |
| Paid/unpaid/partial payment tracking | Should Have (FR-010) | Tracking an invoice's payment status over time is a separate, later feature |

Payment tracking must never become a hidden Must-Have dependency.

## Scope-Control Rule

If a feature is not Must Have, it must **not** be built until every Must-Have item works and is tested. No exceptions before Ashoj 11.
