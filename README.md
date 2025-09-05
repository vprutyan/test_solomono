# Simple PHP Product Catalog

A basic PHP project (no frameworks) to display products and categories with Bootstrap styling, AJAX filtering/sorting, and modal buy prompts.

## Features

- MySQL database: products and categories tables
- OOP PHP structure, singleton DB connection
- Bootstrap layout and styling
- AJAX for category filtering and sorting (no page reload)
- Product "Buy" modal via Bootstrap
- JS templates loaded from HTML files
- State saved in URL GET parameters

## Folder Structure

```
/classes           # PHP classes (DB, Product, Category, etc.)
/assets            # JS, CSS, images, templates
/assets/templates  # HTML templates for JS rendering
/migrations        # SQL files for DB initialization
/init              # DB initialization marker files
index.php          # Main page
ajax.php           # AJAX handler
autoload.php       # PHP autoloader
README.md          # This file
```

## Setup

1. **Configure MySQL:**
   - Create a database.
   - Copy `env.example.php` to `env.php` and enter your DB credentials.
2. **Run the app:**
   - Open `index.php` in your browser.
   - On first run, the app initializes your DB via `migrations/products_categories.sql` and creates a marker file in `/init`.
3. **Add products/categories:**
   - Edit SQL or use MySQL directly.

## Notes

- To add new DB tables, create a new SQL file and marker file.
- You can add more templates in `/assets/templates`.
- The app is designed for learning and small projects; feel free to extend!