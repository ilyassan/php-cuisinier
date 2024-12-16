-- Drop tables if exist
DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS menu_dishes;
DROP TABLE IF EXISTS menus;
DROP TABLE IF EXISTS dishes;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name ENUM('client', 'chef') NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL UNIQUE,
    last_name VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY(role_id) REFERENCES roles(id)
);

CREATE TABLE menus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(5,2) NOT NULL,
    description TEXT
);

CREATE TABLE dishes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE menu_dishes (
    menu_id INT NOT NULL,
    dish_id INT NOT NULL,
    PRIMARY KEY (menu_id, dish_id),
    FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE,
    FOREIGN KEY (dish_id) REFERENCES dishes(id) ON DELETE CASCADE
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_date DATETIME NOT NULL,
    number_of_guests INT NOT NULL,
    status ENUM('pending', 'approved', 'declined') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    client_id INT NOT NULL,
    menu_id INT NOT NULL,
    FOREIGN KEY (client_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menus(id)
);





-- Insert Roles
INSERT INTO roles (name) VALUES ('client');
INSERT INTO roles (name) VALUES ('chef');

-- Insert Users (Clients and Chefs)
INSERT INTO users (first_name, last_name, email, password_hash, role_id) 
VALUES ('john', 'doe', 'john@example.com', 'hashed_password_1', 1);
INSERT INTO users (first_name, last_name, email, password_hash, role_id) 
VALUES ('mahmoud', 'ramsey', 'jane@chef.com', 'hashed_password_2', 2);

-- Insert Menus
INSERT INTO menus (name, price, description) 
VALUES ('Gourmet Dinner', 59.99, 'A luxury five-course meal curated by Chef Jane.');
INSERT INTO menus (name, price, description) 
VALUES ('Vegetarian Delight', 39.99, 'A healthy, plant-based, three-course menu.');
INSERT INTO menus (name, price, description) 
VALUES ('Seafood Feast', 79.99, 'A special seafood menu including lobster, shrimp, and more.');

-- Insert Dishes
INSERT INTO dishes (name) 
VALUES ('Grilled Salmon');
INSERT INTO dishes (name) 
VALUES ('Vegetable Stir-fry');
INSERT INTO dishes (name) 
VALUES ('Lobster Bisque');
INSERT INTO dishes (name) 
VALUES ('Caesar Salad');
INSERT INTO dishes (name) 
VALUES ('Chocolate Lava Cake');

-- Insert Menu-Dish Relationships (Menu Dishes)
INSERT INTO menu_dishes (menu_id, dish_id) 
VALUES (1, 1); -- Gourmet Dinner -> Grilled Salmon
INSERT INTO menu_dishes (menu_id, dish_id) 
VALUES (1, 4); -- Gourmet Dinner -> Caesar Salad
INSERT INTO menu_dishes (menu_id, dish_id) 
VALUES (2, 2); -- Vegetarian Delight -> Vegetable Stir-fry
INSERT INTO menu_dishes (menu_id, dish_id) 
VALUES (3, 3); -- Seafood Feast -> Lobster Bisque
INSERT INTO menu_dishes (menu_id, dish_id) 
VALUES (3, 5); -- Seafood Feast -> Chocolate Lava Cake

-- Insert Reservations
INSERT INTO reservations (reservation_date, number_of_guests, status, client_id, menu_id) 
VALUES ('2024-12-20 19:00:00', 4, 'approved', 1, 1); -- John Doe, Gourmet Dinner
INSERT INTO reservations (reservation_date, number_of_guests, status, client_id, menu_id) 
VALUES ('2024-12-22 18:30:00', 2, 'pending', 1, 2); -- John Doe, Vegetarian Delight
INSERT INTO reservations (reservation_date, number_of_guests, status, client_id, menu_id) 
VALUES ('2024-12-21 20:00:00', 6, 'approved', 2, 3); -- Chef Jane, Seafood Feast
