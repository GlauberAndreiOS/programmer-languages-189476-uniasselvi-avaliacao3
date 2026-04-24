CREATE DATABASE IF NOT EXISTS avaliacao3;
USE avaliacao3;

CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(10) NOT NULL,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    ano_fabricacao INT NOT NULL,
    ano_modelo INT NOT NULL,
    cor VARCHAR(30) NOT NULL,
    combustivel VARCHAR(30) NOT NULL,
    quilometragem INT NOT NULL,
    chassi VARCHAR(17) NOT NULL,
    renavam VARCHAR(11) NOT NULL,
    data_cadastro DATE NOT NULL,
    observacoes TEXT
);