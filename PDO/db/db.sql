CREATE DATABASE IF NOT EXISTS ejercicios_php_mysql;

USE ejercicios_php_mysql;

CREATE TABLE ejercicio10_usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre varchar(20) NOT NULL,
    pass varchar(50) NOT NULL,
    UNIQUE(nombre)
) Engine = InnoDB;