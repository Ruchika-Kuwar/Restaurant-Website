CREATE DATABASE IF NOT EXISTS restaurant_db;
USE restaurant_db;

-----------MENU-------------
CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL
);

INSERT INTO menu (name, price, image) VALUES
('Burger', 120, 'burger.jpg'),
('Pizza', 250, 'pizza.jpg'),
('Pasta', 180, 'pasta.jpg');

----------ORDER--------------
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    customer_name VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    total DECIMAL(10,2),
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

----------ORDER ITEMS-----------
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    item_name VARCHAR(255),
    price DECIMAL(10,2),
    quantity INT,

    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-------------ADMIN-------------
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    password VARCHAR(255)
);
INSERT INTO admin (username, password)
VALUES ('admin', '$2y$10$8zKR31unI1WsLO5bKZUFxOdT88qk4spyf.9C0sbE8kcwdCwCvc1oS');

-------------USER-----------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100)
);
ALTER TABLE users 
ADD phone VARCHAR(20),
ADD address TEXT;

-------------CONTACT-----------------
CREATE TABLE contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);