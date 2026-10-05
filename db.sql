CREATE DATABASE cafe;
USE cafe;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ds_function VARCHAR(50) NOT NULL
);

CREATE TABLE caixa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    saldo_init DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    saldo_final DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    divergencia DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    closed_at TIMESTAMP NULL
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE mesa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero INT NOT NULL UNIQUE,
    capacidade INT NOT NULL,
    estado ENUM('disponivel', 'em uso', 'reservada') DEFAULT 'disponivel',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE comanda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    mesa_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    estado ENUM('aberta', 'fechada') DEFAULT 'aberta',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    closed_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (mesa_id) REFERENCES mesa(id)
);

create table pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    mesa_id INT NOT NULL,
    comanda_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    estado ENUM('pedido', 'completado', 'cancelado') DEFAULT 'pedido',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (mesa_id) REFERENCES mesa(id),
    FOREIGN KEY (comanda_id) REFERENCES comanda(id)
);

CREATE TABLE pedido_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

CREATE TABLE formas_pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,           
    codigo_fiscal VARCHAR(2) NOT NULL,   -- Exigência da SEFAZ: 01=Dinheiro, 03=Crédito, 04=Débito, 17=PIX
    taxa DECIMAL(5, 2) DEFAULT 0.00      
);

CREATE TABLE comanda_pagamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comanda_id INT NOT NULL,
    forma_pagamento_id INT NOT NULL,
    caixa_id INT NOT NULL,               
    valor DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (comanda_id) REFERENCES comanda(id),
    FOREIGN KEY (forma_pagamento_id) REFERENCES formas_pagamento(id),
    FOREIGN KEY (caixa_id) REFERENCES caixa(id)
);