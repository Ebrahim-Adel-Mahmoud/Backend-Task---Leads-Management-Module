# Leads Management Module

A production-ready **Leads Management Module** built with **Laravel 12** using **Blade** (no REST APIs), following clean architecture principles and Laravel best practices.

---

## Overview

This application manages:

* **Leads** (Customers)
* **Deals** (Sales opportunities)
* **Actions** (Calls & Meetings)

### Relationships

* A **Lead** has many **Deals**
* A **Deal** belongs to one **Lead**
* A **Deal** has many **Actions**
* An **Action** belongs to one **Deal**

Business rules are enforced using foreign keys, validation, and Eloquent relationships.

---

## Tech Stack

* Laravel 12
* PHP 8.3+
* MySQL
* Blade
* Laravel Breeze
* Bootstrap 5

---

## Architecture

The project follows a layered architecture to keep controllers clean and business logic organized.

```text
Controller
    ↓
DTO
    ↓
Repository
    ↓
Eloquent Model
```

### Project Structure

```text
app/
├── DTOs
├── Enums
├── Http
│   ├── Controllers
│   └── Requests
├── Models
├── Repositories
├── Support
│   └── ValidationRules
```

---

## Features

### Leads

* Create
* View
* Update
* Delete
* Search
* Pagination

### Deals

* Assign to Lead
* Status Management
* Budget Tracking
* Search
* Filter by Status
* Sorting
* Pagination

### Actions

* Assign to Deal
* Call / Meeting
* Schedule Date & Time
* Search
* Filter by Type
* Pagination

---

## Implemented Features

| Feature                       | Status       |
| ----------------------------- | ------------ |
| Laravel Breeze Authentication | ✅            |
| Full Blade CRUD (No REST API) | ✅            |
| Repository Pattern            | ✅            |
| DTO Pattern                   | ✅            |
| Shared Validation Rules       | ✅            |
| PHP Enums (Label & Color)     | ✅            |
| Thin Controllers              | ✅            |
| Search                        | ✅            |
| Sorting                       | ✅            |
| Pagination                    | ✅            |
| Eager Loading (No N+1)        | ✅            |
| Foreign Keys                  | ✅            |
| Cascade Delete                | ✅            |
| Flash Messages                | ✅            |
| Active Navigation (`routeIs`) | ✅            |
| Database Seeder               | ✅            |
| Feature Tests                 | ✅ 19 Passing |
| PSR-12                        | ✅            |
| `declare(strict_types=1)`     | ✅            |

---

## Performance

The application includes several optimizations:

* Eager Loading to eliminate N+1 queries
* Pagination
* Search & Filtering
* Safe Sortable Columns
* Repository Abstraction
* Thin Controllers
* Optimized Eloquent Relationships

---

## Validation

Validation is handled using dedicated **Form Request** classes and reusable validation rules located in the `Support/ValidationRules` directory.

---

## Enums

PHP Enums are used instead of hardcoded strings.

### Deal Status

* New
* In Progress
* Won
* Lost

### Action Type

* Call
* Meeting

Each Enum provides helper methods for display labels and UI colors.

---

## Authentication

Authentication is implemented using **Laravel Breeze**.

Protected resources:

* Leads
* Deals
* Actions

Unauthenticated users are automatically redirected to the login page.

---

## Database

Entity relationships:

```text
Lead
 └── Deals
      └── Actions
```

Foreign keys with **Cascade Delete** ensure data integrity and prevent orphan records.

---

## Testing

Feature tests cover:

* Authentication
* Authorization
* Create
* Update
* Delete
* Validation
* Search
* Filters

```bash
19 Passing Tests
```

Run all tests:

```bash
php artisan test
```

---

## Installation

Clone the repository:

```bash
git clone https://github.com/Ebrahim-Adel-Mahmoud/Backend-Task---Leads-Management-Module.git
```

Install dependencies:

```bash
composer install
```

Copy the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Run database migrations and seed demo data:

```bash
php artisan migrate --seed
```

Install frontend dependencies:

```bash
npm install
npm run dev
```

Start the development server:

```bash
php artisan serve
```

---

## Demo Credentials

```text
Email: admin@example.com
Password: 12345678
```

---

## Code Style

* PSR-12
* Strict Types
* Repository Pattern
* DTO Pattern
* PHP Enums
* Laravel Best Practices
* Clean Architecture Principles

---

## Contributors

* **Ebrahim Adel Mahmoud** (@Ebrahim-Adel-Mahmoud) — Backend Laravel Engineer

---

## Author

<a href="https://github.com/Ebrahim-Adel-Mahmoud">
  <img src="https://github.com/Ebrahim-Adel-Mahmoud.png" width="100" />
</a>

**Ebrahim Adel Mahmoud**  
Backend Laravel Engineer

Made with ❤️ using Laravel 12.
