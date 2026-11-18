CREATE DATABASE IF NOT EXISTS hms;
USE hms;

CREATE TABLE admin (
  username VARCHAR(50) PRIMARY KEY,
  password VARCHAR(50) NOT NULL
);

INSERT INTO admin (username, password) VALUES ('admin', 'admin123');

CREATE TABLE doctreg (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  docFees INT NOT NULL
);

INSERT INTO doctreg (username, password, email, docFees) VALUES 
('Ganesh', 'ganesh123', 'ganesh@tamarawhospital.com', 500);

CREATE TABLE patreg (
  pid INT AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR(50) NOT NULL,
  lname VARCHAR(50) NOT NULL,
  gender VARCHAR(10) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  contact VARCHAR(15) NOT NULL,
  password VARCHAR(100) NOT NULL
);

CREATE TABLE appointmenttb (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  pid INT NOT NULL,
  fname VARCHAR(50) NOT NULL,
  lname VARCHAR(50) NOT NULL,
  gender VARCHAR(10) NOT NULL,
  email VARCHAR(100) NOT NULL,
  contact VARCHAR(15) NOT NULL,
  doctor VARCHAR(100) NOT NULL,
  docFees INT NOT NULL,
  appdate DATE NOT NULL,
  apptime TIME NOT NULL,
  userStatus INT(1) NOT NULL DEFAULT 1,
  doctorStatus INT(1) NOT NULL DEFAULT 1
);

CREATE TABLE contact (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  contact VARCHAR(15) NOT NULL,
  message TEXT NOT NULL
);