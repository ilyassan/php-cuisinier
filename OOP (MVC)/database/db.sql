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

-- Insert Users (30 Clients and 1 Chef)
INSERT INTO users (first_name, last_name, email, password_hash, role_id) 
VALUES ('Gordon', 'Ramsay', 'gordon.chef@example.com', 'hashed_password_chef', 2);

INSERT INTO users (first_name, last_name, email, password_hash, role_id) 
VALUES 
('Alice', 'Smith', 'alice.smith@example.com', 'hashed_password1', 1),
('Bob', 'Johnson', 'bob.johnson@example.com', 'hashed_password2', 1),
('Charlie', 'Williams', 'charlie.williams@example.com', 'hashed_password3', 1),
('Diana', 'Brown', 'diana.brown@example.com', 'hashed_password4', 1),
('Eve', 'Jones', 'eve.jones@example.com', 'hashed_password5', 1),
('Frank', 'Garcia', 'frank.garcia@example.com', 'hashed_password6', 1),
('Grace', 'Miller', 'grace.miller@example.com', 'hashed_password7', 1),
('Hank', 'Davis', 'hank.davis@example.com', 'hashed_password8', 1),
('Ivy', 'Martinez', 'ivy.martinez@example.com', 'hashed_password9', 1),
('Jack', 'Hernandez', 'jack.hernandez@example.com', 'hashed_password10', 1),
('Kara', 'Lee', 'kara.lee@example.com', 'hashed_password11', 1),
('Liam', 'Young', 'liam.young@example.com', 'hashed_password12', 1),
('Mona', 'Hill', 'mona.hill@example.com', 'hashed_password13', 1),
('Noah', 'Clark', 'noah.clark@example.com', 'hashed_password14', 1),
('Olivia', 'Adams', 'olivia.adams@example.com', 'hashed_password15', 1),
('Paul', 'Baker', 'paul.baker@example.com', 'hashed_password16', 1),
('Quinn', 'Allen', 'quinn.allen@example.com', 'hashed_password17', 1),
('Rachel', 'Scott', 'rachel.scott@example.com', 'hashed_password18', 1),
('Sam', 'Harris', 'sam.harris@example.com', 'hashed_password19', 1),
('Tina', 'Nelson', 'tina.nelson@example.com', 'hashed_password20', 1),
('Umar', 'Carter', 'umar.carter@example.com', 'hashed_password21', 1),
('Vera', 'Mitchell', 'vera.mitchell@example.com', 'hashed_password22', 1),
('Will', 'Perez', 'will.perez@example.com', 'hashed_password23', 1),
('Xena', 'Roberts', 'xena.roberts@example.com', 'hashed_password24', 1),
('Yara', 'Murphy', 'yara.murphy@example.com', 'hashed_password25', 1),
('Zane', 'Bell', 'zane.bell@example.com', 'hashed_password26', 1),
('Amy', 'Diaz', 'amy.diaz@example.com', 'hashed_password27', 1),
('Ben', 'Lopez', 'ben.lopez@example.com', 'hashed_password28', 1),
('Cara', 'Martins', 'cara.martins@example.com', 'hashed_password29', 1),
('David', 'Griffin', 'david.griffin@example.com', 'hashed_password30', 1);

UPDATE users
SET password_hash = "$2y$10$Gk.mQoxzNPbT05iji4oMMugFGnhp2UVBHvTWo7AfL6mcfDtB0kssq";

-- Insert Menus
INSERT INTO menus (name, price, description) 
VALUES ('Breakfast Special', 15.99, 'A delicious breakfast platter'),
       ('Lunch Combo', 25.99, 'A hearty lunch meal'),
       ('Dinner Delight', 35.99, 'A sumptuous dinner'),
       ('Vegan Feast', 29.99, 'A feast for vegan lovers'),
       ('Seafood Paradise', 45.99, 'A variety of seafood dishes'),
       ('Meat Lovers BBQ', 50.99, 'A BBQ feast for meat lovers'),
       ('Italian Classics', 40.99, 'Traditional Italian cuisine'),
       ('Asian Fusion', 38.99, 'A mix of Asian flavors'),
       ('Mexican Fiesta', 32.99, 'Spicy and vibrant Mexican dishes'),
       ('Dessert Heaven', 20.99, 'Sweet and savory desserts'),
       ('Healthy Choices', 28.99, 'Healthy yet tasty dishes'),
       ('Comfort Food', 30.99, 'Warm and comforting meals');

-- Insert Dishes
INSERT INTO dishes (name) 
VALUES ('Pancakes'), ('Omelette'), ('Caesar Salad'), ('Grilled Chicken'),
       ('Spaghetti Bolognese'), ('Margherita Pizza'), ('Sushi Platter'),
       ('Chicken Tacos'), ('Steak Frites'), ('Lobster Bisque'),
       ('Vegan Burger'), ('Grilled Salmon'), ('Chocolate Cake'),
       ('Fruit Salad'), ('Pumpkin Soup'), ('Beef Stew'), ('Spring Rolls'),
       ('Pad Thai'), ('Garlic Bread'), ('Cheesecake'), ('Fish and Chips'),
       ('Shrimp Scampi'), ('Chicken Curry'), ('Vegetable Stir-fry'),
       ('Stuffed Peppers'), ('Tomato Soup'), ('Rice Pudding'),
       ('Apple Pie'), ('Roast Turkey'), ('Mashed Potatoes'),
       ('Bruschetta'), ('Caprese Salad'), ('Pork Ribs'),
       ('BBQ Wings'), ('Nachos'), ('Fajitas'), ('Pasta Primavera'),
       ('Ratatouille'), ('Stuffed Mushrooms'), ('Tiramisu');

-- Associate Menus with Dishes
INSERT INTO menu_dishes (menu_id, dish_id) 
VALUES 
(1, 1), (1, 2), (2, 3), (2, 4), (3, 5), (3, 6), 
(4, 7), (4, 8), (5, 9), (5, 10), (6, 11), (6, 12), 
(7, 13), (7, 14), (8, 15), (8, 16), (9, 17), (9, 18), 
(10, 19), (10, 20), (11, 21), (11, 22), (12, 23), (12, 24);

-- Insert Reservations
INSERT INTO reservations (reservation_date, number_of_guests, status, client_id, menu_id) 
VALUES 
('2024-12-10 12:00:00', 2, 'approved', 1, 1),
('2024-12-11 19:00:00', 4, 'approved', 1, 2),
('2024-12-12 18:30:00', 3, 'approved', 1, 3),
('2024-12-09 13:00:00', 2, 'pending', 2, 4),
('2024-12-15 20:00:00', 5, 'approved', 2, 5),
('2024-12-14 12:30:00', 4, 'declined', 2, 6),
('2024-12-10 18:00:00', 3, 'approved', 3, 7),
('2024-12-12 19:30:00', 6, 'approved', 3, 8),
('2024-12-13 20:00:00', 2, 'pending', 3, 9),
('2024-12-14 12:00:00', 3, 'approved', 4, 10),
('2024-12-09 18:00:00', 2, 'approved', 4, 11),
('2024-12-13 19:30:00', 4, 'pending', 4, 12),
('2024-12-11 18:30:00', 5, 'approved', 5, 1),
('2024-12-10 20:00:00', 6, 'approved', 5, 2),
('2024-12-15 12:00:00', 4, 'approved', 5, 3),
('2024-12-14 13:00:00', 3, 'pending', 6, 4),
('2024-12-12 19:00:00', 4, 'approved', 6, 5),
('2024-12-10 20:30:00', 2, 'approved', 6, 6),
('2024-12-11 18:00:00', 3, 'approved', 7, 7),
('2024-12-12 19:30:00', 6, 'approved', 7, 8),
('2024-12-13 20:00:00', 2, 'pending', 7, 9),
('2024-12-14 12:00:00', 4, 'approved', 8, 10),
('2024-12-09 18:00:00', 2, 'approved', 8, 11),
('2024-12-15 19:30:00', 4, 'pending', 8, 12),
('2024-12-10 12:30:00', 3, 'approved', 9, 1),
('2024-12-11 19:00:00', 5, 'approved', 9, 2),
('2024-12-12 20:30:00', 6, 'approved', 9, 3),
('2024-12-15 12:00:00', 4, 'pending', 10, 4),
('2024-12-09 13:00:00', 2, 'approved', 10, 5),
('2024-12-14 19:30:00', 4, 'declined', 10, 6),
('2024-12-10 18:00:00', 3, 'approved', 11, 7),
('2024-12-12 19:30:00', 6, 'approved', 11, 8),
('2024-12-13 20:00:00', 2, 'pending', 11, 9),
('2024-12-14 12:00:00', 3, 'approved', 12, 10),
('2024-12-09 18:00:00', 2, 'approved', 12, 11),
('2024-12-22 19:30:00', 4, 'pending', 12, 12),
('2024-12-22 18:30:00', 5, 'approved', 13, 1),
('2024-12-21 20:00:00', 6, 'approved', 13, 2),
('2024-12-21 12:00:00', 4, 'approved', 13, 3);
