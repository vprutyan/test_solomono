-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    date DATE NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Insert categories
INSERT INTO categories (name) VALUES 
('Electronics'), 
('Books'), 
('Clothing'), 
('Home');

-- Insert products
INSERT INTO products (name, price, date, category_id) VALUES
('Smartphone', 299.99, '2025-08-20', 1),
('Laptop', 899.99, '2025-08-15', 1),
('Headphones', 49.99, '2025-08-05', 1),
('E-Reader', 119.99, '2025-08-10', 1),
('Novel: The Great Adventure', 14.99, '2025-08-01', 2),
('Science Textbook', 59.99, '2025-08-02', 2),
('Cookbook', 25.00, '2025-08-04', 2),
('Children Book', 9.99, '2025-08-07', 2),
('Jeans', 39.99, '2025-08-03', 3),
('T-shirt', 19.99, '2025-08-06', 3),
('Jacket', 59.99, '2025-08-08', 3),
('Dress', 49.99, '2025-08-09', 3),
('Coffee Maker', 89.99, '2025-08-12', 4),
('Vacuum Cleaner', 129.99, '2025-08-13', 4),
('Desk Lamp', 29.99, '2025-08-14', 4),
('Sofa', 499.99, '2025-08-16', 4),
('Tablet', 199.99, '2025-08-17', 1),
('Bluetooth Speaker', 39.99, '2025-08-18', 1),
('Mystery Novel', 17.99, '2025-08-19', 2),
('Sweater', 34.99, '2025-08-21', 3);