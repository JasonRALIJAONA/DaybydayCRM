CREATE DATABASE crm;
USE crm;

CREATE TABLE discounts(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    value DECIMAL(5, 2) NOT NULL
);

INSERT INTO discounts(name, value) VALUES('General discount', 10.00);