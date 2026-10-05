# Gestion de Trésorerie

## 📌 Overview
Gestion de Trésorerie is a Laravel-based treasury and cash-flow management application designed to help a company track financial movements, manage contacts, monitor invoices, and handle incoming and outgoing cheques. The project centralizes treasury operations in a single interface, with role-based access for administrative users and a super-admin oversight layer.

## ✨ Features
- Dashboard with cash-flow KPIs, balances, recent transactions, and due-date alerts
- Contact management for clients and suppliers
- Invoice creation, tracking, payment allocation, and status updates
- Incoming cheque and “effet” management with deposit and endorsement workflows
- Outgoing cheque management and direct payment tracking
- Remittance generation and bank export workflow
- Rejection and litigation tracking for failed cheques
- Bank account and cheque book administration
- User management and permission-based access control
- Support center and notification system for internal follow-up

## 🛠️ Technologies
- PHP 8.2
- Laravel 12
- Composer
- Blade templates
- Eloquent ORM
- SQLite (default local configuration)
- Vite
- Tailwind CSS
- Node.js and npm
- PHPUnit (basic test setup)

## 🏗️ Project Structure
```text
.
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   ├── Notifications/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   ├── seeders/
│   └── database.sqlite
├── extracted_stitch/
├── lang/
├── public/
├── resources/
│   ├── js/
│   ├── css/
│   └── views/
├── routes/
│   └── web.php
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
├── phpunit.xml
├── vite.config.js
├── .gitignore
└── README.md
```

## ⚙️ Requirements
- PHP 8.2 or later
- Composer
- Node.js and npm
- SQLite as the default local database, or another Laravel-supported database if configured
- A modern browser for the web interface

## 🚀 Installation
1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd "Gestion de Trésorerie - v8"
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Create the environment file from the example:
   ```bash
   copy .env.example .env
   ```
   On Linux/macOS, use:
   ```bash
   cp .env.example .env
   ```
4. Generate the application key:
   ```bash
   php artisan key:generate
   ```
5. Ensure the SQLite database file exists if you are using the default configuration:
   ```bash
   touch database/database.sqlite
   ```
   On Windows PowerShell, you can create the file with:
   ```powershell
   New-Item database\database.sqlite -ItemType File
   ```
6. Run the database migrations and seed the demo data:
   ```bash
   php artisan migrate --seed
   ```
7. Install the front-end dependencies:
   ```bash
   npm install
   ```
8. Build the front-end assets:
   ```bash
   npm run build
   ```

## 🔧 Configuration
The project ships with a default `.env.example` file. Before running the app, copy it to `.env` and review the most important values:

- `APP_NAME` and `APP_URL`
- `APP_ENV` and `APP_DEBUG`
- `DB_CONNECTION` (default is `sqlite`)
- `SESSION_DRIVER`, `QUEUE_CONNECTION`, and `CACHE_STORE`
- `MAIL_*` variables if you want to enable mail notifications
- `VITE_APP_NAME`

If you use a database other than SQLite, update the matching `DB_*` variables in the `.env` file.

Do not commit real credentials, API keys, or production secrets to the repository.

## ▶️ Running the Project
To run the application locally, you can use the default Laravel development stack:

```bash
composer run dev
```

This script starts the Laravel server, queue worker, logs, and Vite development server together.

Alternatively, run the server and front-end build separately in different terminals:

```bash
php artisan serve
npm run dev
```

Then open the local application in your browser:

```text
http://localhost:8000
```

## 🗄️ Database
The project is configured for SQLite by default in `.env.example`, and the repository includes a `database/database.sqlite` file for local development. The database layer is managed through Laravel migrations, and the schema covers:

- companies
- users
- contacts
- bank accounts
- cheque books
- incoming cheques
- outgoing cheques
- invoices
- remittances
- rejections
- payments
- activity logs
- support and notification tables

The `database/seeders/DatabaseSeeder.php` file creates demo records such as a super-admin user, a sample company, bank account data, and example contacts.

## 📂 Project Structure
- `app/Models`: Eloquent models for the core business entities such as `User`, `Company`, `Contact`, `Invoice`, `IncomingCheque`, and `OutgoingCheque`.
- `app/Http/Controllers/Web`: application controllers for the dashboard, invoices, treasury, cheques, exports, support, and administration.
- `routes/web.php`: route definitions, permission checks, and role-based access limits.
- `resources/views`: Blade templates for the user interface and forms.
- `database/migrations`: SQL schema definitions for the application database.
- `database/seeders`: demo data for local development and testing.
- `public/`: public static assets and generated application entry points.
- `config/`: Laravel configuration for security, services, queues, sessions, and more.
- `tests/`: PHPUnit test setup and example tests.

## 🔐 Security
The application includes the following implemented security features:

- Laravel authentication and session handling
- Role-based access control using user roles and permission checks
- Email verification support for user accounts
- Password reset flow
- Admin-only routes for sensitive treasury and user-management actions

This project does not include a production-grade security review or a custom security layer beyond the standard Laravel features present in the codebase.

## 🧪 Testing
The project includes a basic Laravel PHPUnit setup and a sample test under `tests/Feature/ExampleTest.php`.

Run the test suite with:

```bash
php artisan test
```

The current test setup is minimal and should be expanded for more complete application coverage before production use.

## 🚧 Known Limitations
- The default configuration is intended for local development and uses SQLite.
- The project contains a basic test setup but not a comprehensive automated test coverage suite.
- The repository does not include screenshots or demo media for the application.
- There is no dedicated API documentation in the repository for external integrations.
- The application appears to be a business-specific treasury tool rather than a generic SaaS starter template.

## 🔮 Future Improvements
The following are realistic future ideas for the project, not existing features:

- Add more detailed financial reporting and export options
- Expand automated tests for invoice, cheque, and remittance workflows
- Improve notification rules and reminder automation for due dates
- Add more granular audit and approval flows for treasury actions
- Introduce a public API layer for external system integrations

## 👨‍💻 Author
Ayoub Chaigari

## 📄 License
No license has been specified.
