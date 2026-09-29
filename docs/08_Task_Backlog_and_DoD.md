# Task Backlog & Definition of Done — P002: Small Business Management System

## EPIC 1 — Authentication (Must Have)
- [ ] Login form
- [ ] Session handling
- [ ] Password hashing

## EPIC 2 — Products (Must Have)
- [ ] Product table/model
- [ ] Add/edit/delete product
- [ ] Product list

## EPIC 3 — Customers (Must Have)
- [ ] Customer table/model
- [ ] Add/edit/delete customer

## EPIC 4 — Sales (Must Have)
- [ ] Sales table/model
- [ ] Sale items
- [ ] Sale creation (customer optional — support walk-in sales)
- [ ] Product selection
- [ ] Quantity validation
- [ ] Stock validation
- [ ] Stock deduction
- [ ] Total calculation
- [ ] Payment method captured on sale (if applicable)
- [ ] Save sale

## EPIC 5 — Invoices (Must Have)
- [ ] Generate invoice from sale
- [ ] Viewable/printable invoice

## EPIC 6 — Dashboard (Must Have)
- [ ] Today's sales total
- [ ] Low-stock widget
- [ ] Recent sales

## EPIC 7 — Backup/Export (Must Have)
- [ ] Export/backup action

## EPIC 8 — Optional Extension (only after Epics 1–7 are completed and tested)
- [ ] Basic staff login with ordinary access

## EPIC 9 — Should Have (only after Epics 1–7 are completed and tested)
- [ ] Expenses
- [ ] Payment status tracking (paid/unpaid/partial)
- [ ] Reports
- [ ] Search/filter

## EPIC 10 — Testing & Documentation
- [ ] Full sale flow tested end-to-end (including walk-in, no-customer case)
- [ ] README completed
- [ ] Screenshots captured

---

## Definition of Done

A feature is only considered DONE when:

- [ ] Requirement is implemented as specified
- [ ] Validation works
- [ ] Error handling works
- [ ] Happy path has been manually tested
- [ ] At least one failure case has been tested
- [ ] No known critical bug remains
- [ ] Git commit has a meaningful commit message
- [ ] Relevant documentation/README is updated
