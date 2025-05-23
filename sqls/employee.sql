CREATE TABLE employee (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(100) NOT NULL,
    email varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO employee VALUES
(1, 'John Doe', 'john@gmail.com'),
(2, 'Vanya Hargreeves', 'vanya@gmail.com'),
(3, 'Luther Hargreeves', 'luther@gmail.com'),
(4, 'Diego Hargreeves', 'diego@gmail.com'),
(5, 'Klaus Hargreeves', 'klaus@gmail.com'),
(6, 'Ben Hargreeves', 'ben@gmail.com'),
(7, 'The Handler', 'handler@gmail.com');
