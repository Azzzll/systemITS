CREATE DATABASE its_db;
USE its_db;
CREATE TABLE roles (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role_id INT,
    first_name VARCHAR(255),
    surname VARCHAR(255),
    last_name VARCHAR(255),
    FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE SET NULL
    );
CREATE TABLE permissions (
    permission_id INT PRIMARY KEY AUTO_INCREMENT,
    permission_name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );
CREATE TABLE roles_have_permissions (
	role_id int,
	permission_id int
	);

CREATE TABLE location (
    location_id INT PRIMARY KEY AUTO_INCREMENT,
    department VARCHAR(255),
    audience VARCHAR(255),
    workplace VARCHAR(255),
    prev_department VARCHAR(255) NULL,
    prev_audience VARCHAR(255) NULL,
    prev_workplace VARCHAR(255) NULL
);

CREATE TABLE equipment_category (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);
CREATE TABLE equipment_type (
    type_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);
CREATE TABLE equipment (
    equipment_id INT PRIMARY KEY AUTO_INCREMENT,
    inventory_number VARCHAR(255) NOT NULL,
    serial_number VARCHAR(255) NOT NULL,
    manufacture VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    description TEXT,
    dns_name VARCHAR(255),
    mac_address VARCHAR(255),
    diagonal VARCHAR(50),
    focal_length VARCHAR(50),
    poe BOOLEAN,
    cpu VARCHAR(255),
    ram VARCHAR(50),
    storage VARCHAR(255),
    power_supply VARCHAR(255),
    frame VARCHAR(255),
    length VARCHAR(50),
    port_count INT,
    port_1 VARCHAR(255),
    port_2 VARCHAR(255),
    location_id INT,
    type_id INT,
    category_id INT,
    FOREIGN KEY (location_id) REFERENCES location(location_id) ON DELETE SET NULL,
    FOREIGN KEY (type_id) REFERENCES equipment_type(type_id) ON DELETE SET NULL,
    FOREIGN KEY (category_id) REFERENCES equipment_category(category_id) ON DELETE SET NULL
);
CREATE TABLE requests (
    request_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    equipment_id INT,
    status ENUM('Новая','В работе','На подтверждение','На отклонение','Решена','Отклонена'),
    created_at timestamp,
    updated_at timestamp,
    comment text,
    description text,
    priority int,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (equipment_id) REFERENCES equipment(equipment_id) ON DELETE SET NULL
    );
