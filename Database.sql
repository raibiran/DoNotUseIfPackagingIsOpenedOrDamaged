-- Create the database
CREATE DATABASE student_system;

-- Use the database
USE student_system;

-- Table for students
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    course VARCHAR(100) NOT NULL
);

-- Table for lecturers (if needed later)
CREATE TABLE lecturers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Table for assignments
CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    file_name VARCHAR(255),
    submission_date DATETIME,
    feedback TEXT,
    grade VARCHAR(10),
    FOREIGN KEY (student_id) REFERENCES students(id)
);
