CREATE DATABASE IF NOT EXISTS byd;
USE byd;

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS pecas (
    id_peca INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,       
    preco_custo DECIMAL(10, 2) NOT NULL,  
    quantidade INT NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS compras (
    id_compra INT AUTO_INCREMENT PRIMARY KEY,
    id_peca INT NOT NULL,
    quantidade INT NOT NULL,
    valor_unitario DECIMAL(10, 2) NOT NULL,
    data_compra DATE NOT NULL,
    FOREIGN KEY (id_peca) REFERENCES pecas(id_peca) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS vendas (
    id_venda INT AUTO_INCREMENT PRIMARY KEY,
    id_peca INT NOT NULL,
    id_cliente INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    data_venda DATE NOT NULL,
    FOREIGN KEY (id_peca) REFERENCES pecas(id_peca) ON DELETE CASCADE,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE
);



select * from clientes;

CREATE TABLE IF NOT EXISTS clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL
);

ALTER TABLE clientes MODIFY cpf VARCHAR(20) NULL;

INSERT IGNORE INTO pecas (nome, descricao, preco, preco_custo, quantidade) VALUES 
('Filtro de Cabine BYD Song Plus', 'Filtro de ar-condicionado', 120.00, 45.00, 10),
('Pastilhas de Freio Dianteiras BYD Dolphin', 'Pastilhas de cerâmica', 350.00, 150.00, 5),
('Fluido de Arrefecimento de Bateria EV', 'Líquido térmico 1L', 95.00, 40.00, 20),
('Palhetas Limpa Pára-brisas BYD Seal', 'Par de palhetas silicone', 180.00, 60.00, 8),
('Bateria 12V Auxiliar Moura', 'Bateria para sistemas internos EV', 550.00, 320.00, 3);
