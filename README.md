<p align="center"><img src="https://raw.githubusercontent.com/xReru/wandering-pages/18447d21b6a3b2730a11da2f0c1a3ea972829cc6/public/images/wp-logo.png" width="400" alt="Wandering Pages Logo"></p>

# Wandering Pages - E-commerce Book Store Documentation

## 1. Project Overview
Wandering Pages is a Laravel-based e-commerce platform specializing in book sales. The application provides a complete solution for online book retailing with features for both customers and administrators.

### Key Features:
- User authentication and authorization (Customer & Admin roles)
- Book browsing and searching with filters
- Shopping cart functionality
- Order management system
- Customer profile management
- Admin dashboard with analytics
- Inventory management
- Newsletter subscription
- Rating and review system
- Book archiving system
- Bulk email functionality
- Order status tracking
- Waybill generation

## 2. Tech Stack

### Backend:
- PHP 8.2+
- Laravel 12.0
- MySQL Database
- Laravel Tinker
- Milon Barcode (for product barcodes)

### Frontend:
- Laravel Blade Templates
- JavaScript
- Alpine JS
- CSS
- Vite (Asset Bundling)

## 3. Installation Instructions

### Prerequisites:
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL Database

### Setup Steps:
1. Clone the repository:
```bash
git clone [repository-url]
cd wandering-pages
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Environment setup:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wandering_pages
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations and seeders:
```bash
php artisan migrate --seed
```

7. Start the development server:
```bash
php artisan serve
npm run dev
```

## 4. Usage Guide

### Running the Application
- Development server: `php artisan serve`
- Asset compilation: `npm run dev`

### Default Login Credentials
- Admin:
  - Email: admin@example.com
  - Password: password

### Important Routes
- Home: `/`
- Book Browsing: `/browse-books`
- Admin Login: `/admin/login`
- Admin Dashboard: `/admin/dashboard`
- Customer Dashboard: `/dashboard`
- Cart: `/cart`
- Checkout: `/customers/order/order-checkout`

## 5. Project Structure

### Key Directories:
- `app/` - Core application code
  - `Http/Controllers/` - Application controllers
  - `Models/` - Eloquent models
  - `Services/` - Business logic services
  - `Traits/` - Reusable traits
  - `Observers/` - Model observers
  - `Policies/` - Authorization policies
- `resources/` - Views and frontend assets
- `routes/` - Application routes
- `database/` - Migrations and seeders
- `config/` - Configuration files
- `public/` - Publicly accessible files
- `storage/` - Application storage
- `tests/` - Application tests

## 6. API Reference

### Book Management
- `GET /browse-books` - List all books
- `GET /api/filtered-books` - Get filtered book list
- `GET /search-books` - Search books
- `GET /books/{book}` - Get book details

### Cart Operations
- `GET /cart` - Get cart contents
- `POST /cart/add` - Add item to cart
- `POST /cart/update/{item}` - Update cart item
- `DELETE /cart/remove/{item}` - Remove item from cart

### Order Management
- `GET /customers/orders` - List customer orders
- `POST /customers/order/submit` - Submit new order
- `GET /customers/orders/{order}` - Get order details
- `POST /orders/{order}/cancel` - Cancel order

### Admin Operations
- `GET /admin/books` - List all books (admin)
- `POST /admin/books` - Create new book
- `PUT /admin/books/{book}` - Update book
- `DELETE /admin/books/{book}` - Delete book
- `GET /admin/orders` - List all orders
- `POST /admin/orders/{order}/status` - Update order status

## 8. Contributing Guide

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Write/update tests
5. Submit a pull request

---

This documentation provides a comprehensive overview of the Wandering Pages e-commerce application. For more specific details or clarification, please refer to the inline code documentation.

