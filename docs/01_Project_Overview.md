# Project Overview — P002: Small Business Management System

**Project ID:** P002
**Type:** Reusable Software Prototype
**Owner:** Amit Kunwar — Overall Head & Technical Lead, CR8FT Technologies
**Deadline:** Ashoj 11
**Development Principle:** AI-assisted, engineer-owned. AI helps with syntax and drafts; Amit owns every requirement, review, and test decision.

## Purpose
A controlled, reusable management-system prototype that can later be customized for different small businesses.

## Problem
Small businesses often manage products, customers, sales, expenses, and payments through disconnected or manual processes.

## Target Users
Small business owners/staff.

- Admin login/authentication is required (Must Have).
- Basic staff login is an **optional extension**, added only if time remains after all Must-Have features are complete.

## Business Context
P002 is a flagship CR8FT Technologies portfolio project demonstrating reusable business-software capability.

- It is **NOT** a one-off custom build.
- It is **NOT** an enterprise ERP.

## Expected Core Outcome
A working, polished core containing:

- Login/authentication
- Products/services
- Customers
- Sales (including payment method captured at the point of sale)
- Basic inventory
- Invoices
- Dashboard
- Database backup/export

Should-Have features (see [`02_Scope.md`](02_Scope.md)) are added only after all Must-Have functionality works end-to-end.

## Success Criteria
The following core loop must work:

```
Login → Add Product → Record Sale → Generate Invoice → Dashboard Updates
```

- The system runs end-to-end without crashing.
- No Must-Have requirement remains knowingly incomplete.
- The repository contains a clean README and screenshots.

## Explicit Non-Goal
Do **not** build an enterprise ERP. Cut scope before adding unnecessary depth.
