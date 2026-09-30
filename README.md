\# P002 — Small Business Management System



A web-based Small Business Management System developed by \*\*CR8FT Technologies\*\* to manage products, customers, sales, inventory, invoices, reporting, and database backups.



The system is designed as a practical business management application using PHP and MySQL/MariaDB, with a focus on a simple workflow, reliable data handling, and a clean user interface.



\---



\## 📌 Project Information



| \*\*Item\*\*       | \*\*Details\*\*                                                                           |

| -------------- | ------------------------------------------------------------------------------------- |

| Project ID     | P002                                                                                  |

| Project Name   | Small Business Management System                                                      |

| Organization   | CR8FT Technologies                                                                    |

| Primary Owner  | Amit Kunwar                                                                           |

| Project Type   | Business Management Software                                                          |

| Status         | Core system completed                                                                 |

| Repository     | \[GitHub](https://github.com/CR8FT-Technologies/P002-small-business-management-system) |

| Backend        | PHP                                                                                   |

| Database       | MySQL / MariaDB                                                                       |

| Local Server   | XAMPP                                                                                 |

| Authentication | PHP Sessions                                                                          |



\---



\## 🎯 Project Objective



The objective of this project is to develop a practical small-business management system that can handle common business operations from a centralized web application.



The system provides functionality for:



\* Managing products and inventory

\* Managing customers

\* Recording sales

\* Automatically deducting inventory after sales

\* Generating invoices

\* Tracking payment methods and payment status

\* Viewing business statistics and reports

\* Creating database backups



\---



\## ✨ Features



\### Authentication



\* Admin login

\* Session-based authentication

\* Protected application pages

\* Logout functionality

\* Invalid-login error handling



\### Product Management



\* Add products

\* View products

\* Edit products

\* Delete products

\* SKU management

\* Product categories

\* Selling price

\* Stock quantity

\* Low-stock threshold

\* Low-stock identification



\### Customer Management



\* Add customers

\* View customers

\* Edit customers

\* Delete customers

\* Customer contact information

\* Support for walk-in customers during sales



\### Sales Management



\* Create sales

\* Select registered customers

\* Support walk-in customers

\* Select products

\* Quantity validation

\* Automatic stock deduction

\* Payment method selection

\* Payment status tracking

\* Automatic invoice number generation

\* Transaction-based sale processing



\### Invoicing



\* Automatically generated invoices

\* Invoice list

\* Invoice details

\* Customer information

\* Product and quantity information

\* Payment information

\* Printable invoice layout



\### Dashboard



\* Total sales

\* Number of sales

\* Today's sales

\* Today's sale count

\* Total customers

\* Total products

\* Low-stock products

\* Recent sales



\### Reports



\* Overall sales statistics

\* Today's sales statistics

\* Customer and product statistics

\* Low-stock information

\* Recent sales



\### Backup \& Export



\* MySQL database backup using `mysqldump`

\* Timestamped SQL backup files

\* Secure backup download

\* Backup files excluded from Git using `.gitignore`



\---



\## 📊 Feature Overview



| \*\*Feature\*\*                     | \*\*Priority\*\*       | \*\*Status\*\*               |

| ------------------------------- | ------------------ | ------------------------ |

| Admin login/authentication      | Must Have          | ✅ Completed              |

| Products (CRUD)                 | Must Have          | ✅ Completed              |

| Customers (CRUD)                | Must Have          | ✅ Completed              |

| Sales (incl. payment method)    | Must Have          | ✅ Completed              |

| Inventory deduction on sale     | Must Have          | ✅ Completed              |

| Invoicing                       | Must Have          | ✅ Completed              |

| Dashboard                       | Must Have          | ✅ Completed              |

| Backup/export                   | Must Have          | ✅ Completed              |

| Basic staff login               | Optional Extension | ⏸ Not implemented        |

| Expenses                        | Should Have        | ⏸ Not implemented        |

| Payment status tracking         | Should Have        | ✅ Completed              |

| Sales reports (daily/monthly)   | Should Have        | 🟡 Partially implemented |

| Search/filter                   | Should Have        | ⏸ Not implemented        |

| Granular role-based permissions | Could Have         | ⏸ Not implemented        |



\---



\## 🛠️ Technology Stack



\* \*\*PHP 8\*\*

\* \*\*MySQL / MariaDB\*\*

\* \*\*HTML5\*\*

\* \*\*CSS3\*\*

\* \*\*JavaScript\*\*

\* \*\*PHP Sessions\*\*

\* \*\*XAMPP\*\*

\* \*\*Git\*\*

\* \*\*GitHub\*\*



\---



\## 🗂️ Project Structure



```text

P002-small-business-management-system/

│

├── assets/

│   ├── css/

│   └── js/

│

├── auth/

│   ├── login.php

│   └── logout.php

│

├── backup/

│   ├── index.php

│   ├── download.php

│   └── exports/

│

├── config/

│   └── database.php

│

├── customers/

│   ├── index.php

│   ├── create.php

│   ├── edit.php

│   └── delete.php

│

├── dashboard/

│   └── index.php

│

├── database/

│

├── docs/

│   └── screenshots/

│

├── includes/

│   ├── auth.php

│   ├── header.php

│   └── footer.php

│

├── invoices/

│   ├── index.php

│   └── view.php

│

├── products/

│   ├── index.php

│   ├── create.php

│   ├── edit.php

│   └── delete.php

│

├── reports/

│   └── index.php

│

├── sales/

│   ├── index.php

│   ├── create.php

│   └── view.php

│

├── .gitignore

└── README.md

```



\---



\## 🗄️ Database



The application uses a relational MySQL/MariaDB database named:



```text

p002\_business

```



\### Main Tables



\* `users`

\* `customers`

\* `products`

\* `sales`

\* `sale\_items`



\### Relationships



```text

customers

&#x20;   │

&#x20;   └── sales

&#x20;         │

&#x20;         └── sale\_items

&#x20;                 │

&#x20;                 └── products



users

&#x20;   │

&#x20;   └── authentication

```



The sales process uses database transactions to help maintain consistency when creating a sale and deducting stock.



\---



\## ⚙️ Local Setup



\### Requirements



\* XAMPP

\* Apache

\* MySQL / MariaDB

\* PHP 8+

\* Git



\### Installation



1\. Clone the repository:



```bash

git clone https://github.com/CR8FT-Technologies/P002-small-business-management-system.git

```



2\. Place the project in the desired local web-server directory.



3\. Start:



&#x20;  \* Apache

&#x20;  \* MySQL



4\. Create the database:



```text

p002\_business

```



5\. Import the database schema from the project database files.



6\. Configure the database connection in:



```text

config/database.php

```



7\. Open the application through the configured local host.



Example:



```text

http://p002.local

```



\---



\## 🔐 Authentication



The system uses session-based authentication.



A default administrator account is created during project setup.



\*\*Username:\*\*



```text

admin

```



> The administrator password is intentionally not published in this repository. Use the configured local development credentials or create/reset the administrator account during setup.



\---



\## 🧪 Testing



The following core workflows were tested during development.



\### Authentication



\* Successful login

\* Invalid login handling

\* Session protection

\* Logout



\### Products



\* Product creation

\* Product editing

\* Product deletion

\* Stock quantity handling

\* Low-stock threshold



\### Customers



\* Customer creation

\* Customer editing

\* Customer deletion

\* Customer selection during sales

\* Walk-in customer sales



\### Sales



\* Sale creation

\* Product selection

\* Quantity validation

\* Stock deduction

\* Payment method selection

\* Payment status selection

\* Invoice generation



\### Invoices



\* Invoice listing

\* Invoice details

\* Printable invoice output



\### Reports



\* Sales totals

\* Today's sales

\* Customer count

\* Product count

\* Low-stock information

\* Recent sales



\### Backup



\* Database backup generation

\* Timestamped SQL export

\* Backup download



\---



\## 📸 Screenshots



\### Login



!\[Login](docs/screenshots/01-login.png)



\### Dashboard — Overview



!\[Dashboard Overview](docs/screenshots/02-dashboard-1.png)



\### Dashboard — Additional View



!\[Dashboard Additional View](docs/screenshots/03-dashboard-2.png)



\### Products



!\[Products](docs/screenshots/04-products.png)



\### Customers



!\[Customers](docs/screenshots/05-customers.png)



\### Sales



!\[Sales](docs/screenshots/06-sales.png)



\### Invoices



!\[Invoices](docs/screenshots/07-invoices.png)



\### Invoice Details



!\[Invoice Details](docs/screenshots/08-invoice-details.png)



\### Reports



!\[Reports](docs/screenshots/09-reports.png)



\### Backup \& Export



!\[Backup](docs/screenshots/10-backup.png)



\## 📦 Demo Data



The final demonstration dataset contains:



\* \*\*5 products\*\*

\* \*\*3 customers\*\*

\* \*\*4 sales\*\*

\* \*\*4 invoices\*\*

\* \*\*1 administrator account\*\*



The demonstration sales include different payment methods and payment statuses, as well as a walk-in customer transaction.



\---



\## 🔒 Security Notes



\* Database credentials should not be committed to public repositories.

\* Backup SQL files are excluded from Git.

\* Administrator passwords should not be published.

\* Sensitive client information should not be stored in public repositories.

\* Production deployments should use stronger credentials and appropriate server security configuration.



\---



\## ⚠️ Current Limitations



The current version intentionally focuses on the core small-business workflow.



The following features are not yet implemented or are only partially implemented:



\* Staff accounts

\* Granular role-based permissions

\* Expense management

\* Advanced search and filtering

\* Full daily/monthly report filtering

\* Multi-product cart within a single sale

\* Production deployment configuration



\---



\## 🚀 Future Improvements



Possible future improvements include:



\* Multi-product sales cart

\* Advanced search and filtering

\* Full daily/monthly sales reports

\* Expense management

\* Staff accounts

\* Role-based permissions

\* Dashboard charts

\* Improved inventory movement history

\* Supplier management

\* Purchase management

\* Automated scheduled backups

\* Production deployment

\* Enhanced invoice customization



\---



\## 👨‍💻 Development Approach



The project was developed incrementally using:



```text

Plan

&#x20; ↓

Design

&#x20; ↓

Build

&#x20; ↓

Test

&#x20; ↓

Fix

&#x20; ↓

Document

&#x20; ↓

Improve

```



AI tools were used as development assistance for learning, coding, debugging, documentation, and problem solving. All implemented functionality was reviewed and tested during development.



\---



\## 🏢 CR8FT Technologies



\*\*CR8FT Technologies\*\* is a developing software team focused on building practical software projects, learning through real development work, and creating a professional technology portfolio.



\### P002 — Small Business Management System



\*\*Build. Learn. Improve. Grow.\*\*
