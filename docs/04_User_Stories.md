# User Stories — P002: Small Business Management System

## US-1 — Login
As an admin, I want to log in so that only authorized users can access the system.

**Acceptance criteria:**
- [ ] Login accepts username/email + password
- [ ] Invalid credentials show an error rather than crashing
- [ ] Successful login redirects to dashboard

## US-2 — Add Product
As an admin, I want to add a product so that it can be sold.

**Acceptance criteria:**
- [ ] Name, price, quantity are required
- [ ] Negative price/quantity is rejected
- [ ] Product appears in the product list immediately

## US-3 — Record a Sale
As a user, I want to record a sale so that inventory and sales history update.

**Acceptance criteria:**
- [ ] Products can be selected
- [ ] Quantity can be entered and is validated against stock
- [ ] Customer selection is optional — a sale can be saved with no customer (walk-in sale)
- [ ] Total is calculated automatically
- [ ] Sale is saved
- [ ] Inventory is reduced
- [ ] Invoice can be generated
- [ ] Sale appears in sales history

## US-4 — Dashboard
As an admin, I want a dashboard so I can see business status at a glance.

**Acceptance criteria:**
- [ ] Today's total sales is shown
- [ ] Low-stock items are shown
- [ ] Recent sales are shown
- [ ] An empty state is shown when there's no data yet

## US-5 — Backup
As an admin, I want to back up my data so I don't lose it.

**Acceptance criteria:**
- [ ] Backup/export action exists
- [ ] It produces a usable file
