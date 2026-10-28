# Ace360degree Enterprise Suite — Product Admin Dashboard

> A high-performance, responsive e-commerce Product Management Admin Dashboard built with **Laravel**, **Blade**, **Tailwind CSS**, and **MySQL / SQLite**.

---

## 1. Project Overview

The **Ace360degree Product Admin Dashboard** is an enterprise-grade catalog management dashboard inspired by modern multi-channel commerce platforms. It provides merchandisers and store administrators with complete CRUD capabilities, real-time KPI metrics, multi-parameter search and filtering, dynamic sorting, server-side pagination, safe deletion confirmation workflows, and bulk actions.

### Key Metrics & Tech Stack
- **Backend Framework:** Laravel 12 (PHP 8.3+)
- **Templating Engine:** Laravel Blade with escaped output (`{{ }}`) and CSRF protection
- **Frontend / Styling:** Tailwind CSS v4 & Vite
- **Database:** MySQL / SQLite (pre-configured for zero-config SQLite testing, with 1-line switch to MySQL)
- **Architecture Pattern:** MVC with Form Request validation, Eloquent Query Scopes, and Resource routing

---

## 2. Features Implemented

| Feature | Description |
| :--- | :--- |
| **KPI Metrics Cards** | Real-time calculations of Total Products, Active Listings (% coverage), Low Stock Alerts, and Out of Stock counts. |
| **Product CRUD** | Create, view, update, and delete products with image upload support and database persistence. |
| **Multi-Parameter Search & Filters** | Search by partial product title or SKU, combined with Category and Publication Status (Active / Draft / Inactive) filters. |
| **Dynamic Sorting** | Sort by Latest, Oldest, Price (Low–High / High–Low), Stock (Low–High / High–Low), and Name (A–Z / Z–A). |
| **Server-Side Pagination** | Fast server-side `paginate()` query builder maintaining all query string parameters across pages (`withQueryString()`). |
| **Rows Per Page Selector** | Configurable results per page (5, 10, 25, 50). |
| **Auto SKU Generator** | Integrated AJAX endpoint (`POST /products/generate-sku`) generating unique standardized warehouse SKUs (e.g., `ELE-ABC-123`). |
| **Destructive Action Delete Modal** | Two-factor delete safety modal with product snapshot and irreversible confirmation checkbox before the delete button activates. |
| **Bulk Actions** | Multi-select checkboxes to bulk delete, bulk activate, or bulk deactivate products in a single operation. |
| **CSV Catalog Export** | One-click CSV download of currently filtered or all catalog products. |
| **Bottom Dashboard Widgets** | **Critical Stock Replenishment** with quick-reorder triggers, **Catalog SKU Breakdown** with live progress bars, and **Store Channel Sync** status meters. |

---

## 3. Database Schema

The `products` table was designed to satisfy all assignment criteria and UI reference mockups:

| Column | Type | Attributes / Constraints | Purpose |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT` | Primary Key, Auto Increment | Unique record identifier |
| `name` | `VARCHAR(255)` | `NOT NULL` | Product title / name |
| `sku` | `VARCHAR(100)` | `NOT NULL, UNIQUE, INDEX` | Unique warehouse Stock Keeping Unit |
| `description` | `TEXT` | `NULLABLE` | Detailed specifications / markdown notes |
| `price` | `DECIMAL(10,2)` | `NOT NULL, UNSIGNED (>= 0)` | Base regular retail price |
| `sale_price` | `DECIMAL(10,2)` | `NULLABLE, <= price` | Optional discounted promotional price |
| `category` | `VARCHAR(100)` | `NOT NULL, INDEX` | Product grouping (Apparel, Electronics, etc.) |
| `stock_quantity` | `UNSIGNED INT` | `NOT NULL, DEFAULT 0` | Available physical inventory units |
| `low_stock_threshold`| `UNSIGNED INT` | `NOT NULL, DEFAULT 10` | Alert threshold triggering low-stock state |
| `status` | `ENUM` | `Active, Inactive, Draft` | Catalog publication state |
| `image_path` | `VARCHAR(255)` | `NULLABLE` | Relative path to thumbnail in storage |
| `created_at` | `TIMESTAMP` | Standard Eloquent timestamp | Record creation timestamp |
| `updated_at` | `TIMESTAMP` | Standard Eloquent timestamp | Record modification timestamp |

---

## 4. Setup & Installation Guide

Follow these steps to set up the project on any Windows, macOS, or Linux machine.

### Prerequisites
- **PHP >= 8.2** (PHP 8.3 recommended) with extensions: `pdo`, `mbstring`, `openssl`, `curl`, `fileinfo`, `gd`, `intl`, `sqlite3` or `pdo_mysql`.
- **Composer** (v2.x)
- **Node.js** (v18+) & **NPM**

### Step 1: Clone or Navigate to Project
```bash
cd C:\Users\NIKITA\.gemini\antigravity\scratch\ace360degree-dashboard
```

### Step 2: Install Dependencies
```bash
# Install PHP vendor packages
composer install

# Install frontend npm dependencies
npm install
```

### Step 3: Configure Environment (.env)
```bash
# Copy example configuration if .env does not exist
cp .env.example .env

# Generate application encryption key
php artisan key:generate
```

#### Database Option A: SQLite (Default Zero-Config Setup)
The application comes pre-configured with SQLite for instant out-of-the-box execution with zero database server setup required:
```env
DB_CONNECTION=sqlite
```
The database file is automatically located at `database/database.sqlite`.

#### Database Option B: MySQL Setup
If you want to use MySQL (e.g. XAMPP, Laragon, MySQL 8 Server, or Docker):
1. Create a database:
   ```sql
   CREATE DATABASE ace360degree_catalog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. In your `.env` file, uncomment and update the MySQL settings:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ace360degree_catalog
   DB_USERNAME=root
   DB_PASSWORD=your_password_here
   ```

### Step 4: Run Database Migrations & Seeders
Execute the migrations and seeders to create all tables and populate at least 16 realistic products matching the reference mockups:
```bash
php artisan migrate:fresh --seed
```

### Step 5: Link Storage for Image Uploads
Create the symbolic link to make uploaded product images publicly accessible:
```bash
php artisan storage:link
```

### Step 6: Build Frontend Assets
Compile the Tailwind CSS styles and JavaScript assets using Vite:
```bash
npm run build
```
*(Or run `npm run dev` during active frontend development).*

### Step 7: Launch the Application
Start the local Laravel development server:
```bash
php artisan serve
```
Open your browser and navigate to:
```
http://127.0.0.1:8000
```
*(It will automatically redirect to `/products`)*.

---

## 5. Running Automated Tests

A comprehensive suite of feature and unit tests is included, verifying CRUD correctness, validation constraints, search & filter combinations, SKU generation, and CSV export.

```bash
php artisan test
```

### Test Coverage Highlights:
- `test_products_index_page_loads_with_data_and_metrics`: Verifies index status 200, KPI metrics rendering, and product data display.
- `test_search_by_partial_name_and_sku`: Verifies search queries properly filter products by partial title and SKU.
- `test_combined_category_and_status_filters`: Verifies multi-parameter filters execute correctly in combination.
- `test_can_create_product_with_valid_data`: Verifies creation persists records and sets session flash messages.
- `test_duplicate_sku_is_rejected`: Confirms unique validation rule prevents duplicate SKUs.
- `test_negative_values_are_rejected`: Confirms non-negative price and stock quantity constraints.
- `test_can_update_product`: Confirms record modifications persist and preserve SKU uniqueness.
- `test_can_delete_product`: Confirms product deletion removes record from database.
- `test_generate_sku_endpoint`: Validates AJAX SKU generator API response.
- `test_csv_export_endpoint`: Validates CSV catalog streaming and structure.

---

## 6. Architecture & Implementation Explanations

Here are the key technical concepts behind this implementation, structured for technical review:

### A. Routing (`routes/web.php`)
- **Resource Routing:** `Route::resource('products', ProductController::class)` generates all standard RESTful route names: `products.index`, `products.store`, `products.show`, `products.edit`, `products.update`, and `products.destroy`.
- **Specialized Endpoints:** Placed before resource routes to prevent wildcard collision:
  - `POST /products/generate-sku` (`products.generate-sku`)
  - `POST /products/bulk` (`products.bulk`)
  - `GET /products/export` (`products.export`)

### B. Controller & Clean Separation (`ProductController.php`)
- Validation is decoupled from the controller into dedicated Form Requests:
  - `StoreProductRequest`
  - `UpdateProductRequest`
- File upload handling utilizes `Illuminate\Support\Facades\Storage` using the `public` disk, ensuring safe file hashing and cleanup of old images upon product update or deletion.

### C. Eloquent Scopes & Server-side Pagination
- Query Scopes in `app/Models/Product.php` keep queries expressive and reusable:
  - `scopeSearch($query, $term)`: Case-insensitive partial matching on `name` or `sku`.
  - `scopeFilterCategory($query, $category)`: Filters by category if selected.
  - `scopeFilterStatus($query, $status)`: Filters by status if selected.
  - `scopeApplySorting($query, $sortBy)`: Translates sort keys (`price_asc`, `stock_desc`, `latest`) into `orderBy()` clauses.
- **Server-side Pagination with Parameter Preservation:**
  ```php
  $products = $query->paginate($perPage)->withQueryString();
  ```
  Calling `->withQueryString()` ensures that active search terms, selected categories, status filters, and sorting choices remain intact when the user navigates between pagination pages.

### D. Security & Validation
- **CSRF Protection:** All forms include `@csrf` and JavaScript AJAX requests pass `X-CSRF-TOKEN`.
- **SQL Injection Prevention:** All queries use Eloquent parameterized statements.
- **XSS Prevention:** All user inputs rendered in Blade views utilize `{{ $var }}` escaped syntax.
- **Unique SKU Update Safety:** Uses `Rule::unique('products', 'sku')->ignore($product->id)` so updating a product's name or price does not trigger a false duplicate SKU validation error against itself.

---

## 7. Known Limitations & Honest Reflections

1. **Multi-Channel Sync Integration:** The "Store Channel Sync" and "Critical Stock Replenishment" reorder triggers simulate the webhook and API transactions visually. In production, these would connect to real Shopify / Amazon SP-API OAuth connectors and queue asynchronous jobs.
2. **Role-Based Access Control (RBAC):** The Delete modal mentions "Requires Merchandiser Admin Role". Currently, all authenticated users / admins can perform the action; full Spatie Laravel-Permission role gates can be layered on top for multi-tenant teams.
3. **CDN Image Storage:** Thumbnail files are stored on the local public disk (`storage/app/public/products`). For cloud scale, `FILESYSTEM_DISK=s3` can be swapped in `.env` without changing controller code.

---

## 8. Checklist Verification

- [x] **Working implementation rather than static mockup.**
- [x] **Product model, migration, seeder, controller, named routes, and Blade views created.**
- [x] **16 realistic seeded products included.**
- [x] **CRUD complete (Create, List, Show, Edit, Delete).**
- [x] **Search by partial product name or SKU.**
- [x] **Filter by category and status (combined).**
- [x] **Server-side pagination with preserved query parameters.**
- [x] **Reset Filters button clears all parameters.**
- [x] **Two-step delete confirmation modal with irreversible checkbox.**
- [x] **Flash messages for actions (Create, Update, Delete, Bulk).**
- [x] **Empty state handling for zero search/filter results.**
- [x] **Automated test suite passing 100%.**
- [x] **Zero secrets or API keys committed in repository.**
