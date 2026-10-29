# Ace360degree Enterprise Suite

> An enterprise-grade, high-performance retail & multi-channel commerce management application built with **Laravel**, **Blade**, and **MySQL** (Zero React dependencies).

---

## 1. Project Overview & Tech Stack

The **Ace360degree Enterprise Suite** is a unified retail management system featuring a centralized catalog, multi-branch store operations, order fulfillment, vendor relationships, promotion campaigns, marketing analytics, and a live, interactive Point of Sale (POS) cashier terminal.

### Tech Stack
* **Backend:** Laravel 13 (PHP 8.3+)
* **Templating & UI:** Laravel Blade, HTML5, Tailwind CSS v4, Vanilla JavaScript
* **Database:** MySQL 8.x (with optional SQLite support for testing)
* **Architecture:** MVC with Eloquent ORM, Query Scopes, Form Request Validation, CSRF Protection, and Escaped Blade Output (`{{ }}`)
* **Frontend Runtime:** Pure Blade Server-Side Rendering (No React runtime or build overhead)

---

## 2. Core Modules Implemented

| Module | Route | Functionality |
| :--- | :--- | :--- |
| **Authentication** | `/login`, `/register`, `/logout` | User sign in, account registration, session regeneration, remember me, and secure logout. |
| **User Profile** | `/profile` | Authenticated user profile management: update name, update email, and change password with current password verification. |
| **Dashboard** | `/dashboard` | Business overview with live revenue metrics, weekly sales trend charts, recent orders feed, inventory alerts, and module shortcuts. |
| **Product Management** | `/products` | Full CRUD catalog with required database fields, image uploads, search by name/SKU, category/status filters, sorting, server-side pagination (`withQueryString()`), SKU generator, and CSV export. |
| **Store Management** | `/stores` | Branch and outlet registry with store code, operating status, addresses, managers, and search/filter. |
| **Orders Management** | `/orders` | Order fulfillment hub with customer information, channel tracking (Online, In-Store/POS, Marketplace), line items, order status transitions (Pending, Processing, Completed, Cancelled), and financial summaries. |
| **Vendor Management** | `/vendors` | Supplier directory with contact persons, supplied product categories, credit/payment terms (Net 30, COD), and supplier ratings. |
| **Promotions** | `/promotions` | Coupon and promotional rule engine supporting percentage (%) and flat ($) discounts, minimum order thresholds, usage limits, and expiration tracking. |
| **Marketing** | `/marketing` | Growth campaign management with channel allocation (Social Media, Google Ads, Email, SMS), budget vs. ad spend progress, click-through rates (CTR), and conversion attribution. |
| **Point of Sale (POS)** | `/pos` | Real-time cashier terminal with instant search, category filtering, interactive cart, coupon redemption, live stock deduction from MySQL upon checkout, and printable receipt modal. |

---

## 3. Product Catalog Specification

The `products` table satisfies all database and validation criteria:

| Field | Requirement / Type | Description |
| :--- | :--- | :--- |
| `name` | Required string | Product title / name |
| `sku` | Required unique string | Stock Keeping Unit (e.g. `APP-TSH-001`, `ELE-HPH-2024`) |
| `description` | Nullable text | Markdown or detailed description |
| `price` | Decimal(10,2), >= 0 | Base regular retail price |
| `category` | String or category_id | Category grouping (`Apparel`, `Electronics`, `Home & Living`, etc.) |
| `stock_quantity` | Unsigned integer | Available stock units |
| `status` | Active / Inactive | Catalog visibility status |
| `image_path` | Optional string | Relative path to uploaded product photo |
| `timestamps` | `created_at` / `updated_at` | Record audit timestamps |

### Seeded Sample Products
Over 15 realistic products across Apparel, Electronics, and Home & Living are pre-seeded via `ProductSeeder.php`.

---

## 4. Environment (.env) Setup & Security

Secrets and machine-specific credentials are **excluded** from version control via `.gitignore`. 

### Step 1: Copy Environment Template
```bash
cp .env.example .env
```

### Step 2: Generate Application Key
```bash
php artisan key:generate
```

### Step 3: Configure MySQL Connection
In `.env`, configure your local or remote MySQL database credentials:
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ace360degree_catalog
DB_USERNAME=root
DB_PASSWORD=root123
```

> **Note on Secret Exclusion:**
> The `.env` file is explicitly ignored in `.gitignore` to prevent database passwords, API credentials, and application keys from being committed to Git. Only `.env.example` is committed with generic placeholders.

---

## 5. Installation & Launch Steps

### 1. Install Dependencies
```bash
# PHP Dependencies
composer install

# Frontend Assets (Tailwind CSS v4 & Vite)
npm install
npm run build
```

### 2. Run Database Migrations & Seeders
This command runs all migrations and populates sample products, stores, vendors, promotions, marketing campaigns, and orders:
```bash
php artisan migrate:fresh --seed
```

### 3. Start Application
```bash
php artisan serve
```
Visit `http://127.0.0.1:8000` in your web browser. 

#### Demo Admin Account Credentials
* **Email:** `admin@ace360degree.com`
* **Password:** `password123`
*(A "Use Demo Credentials" button is also provided on the sign-in page for 1-click login)*

---

## 6. Automated Testing Suite

The suite comes with an automated feature test suite (16 tests, 63 assertions) utilizing an in-memory SQLite database:
```bash
php artisan test
```

Tests cover:
* Product catalog loading, pagination query preservation, and KPI metrics.
* Product CRUD (creation, validation, editing, deletion).
* Combined search by partial name / SKU and filtering by category & status.
* Store Management CRUD.
* Orders Management status transition.
* Point of Sale (POS) checkout: automated inventory decrement and order creation.
