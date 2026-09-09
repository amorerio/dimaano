-- Create employee_emergency table
CREATE TABLE employee_emergency (
    id INT PRIMARY KEY AUTO_INCREMENT,
    emp_id INT NOT NULL,
    name VARCHAR(100),
    relation VARCHAR(50),
    address VARCHAR(255),
    contact VARCHAR(20),
    FOREIGN KEY (emp_id) REFERENCES employees(id)
);

-- Create employee_dependents table
CREATE TABLE employee_dependents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    emp_id INT NOT NULL,
    name VARCHAR(100),
    birthdate DATE,
    relation VARCHAR(50),
    FOREIGN KEY (emp_id) REFERENCES employees(id)
);

-- Create employee_education table
CREATE TABLE employee_education (
    id INT PRIMARY KEY AUTO_INCREMENT,
    emp_id INT NOT NULL,
    school_name VARCHAR(150),
    address VARCHAR(255),
    school_year VARCHAR(20),
    level VARCHAR(50),
    FOREIGN KEY (emp_id) REFERENCES employees(id)
);

-- Create employee_references table
CREATE TABLE employee_references (
    id INT PRIMARY KEY AUTO_INCREMENT,
    emp_id INT NOT NULL,
    name VARCHAR(100),
    occupation VARCHAR(100),
    address VARCHAR(255),
    contact VARCHAR(20),
    FOREIGN KEY (emp_id) REFERENCES employees(id)
);
