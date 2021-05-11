-- DROP DATABASE bd_poechos;
DROP DATABASE IF EXISTS bd_poechos;
CREATE DATABASE bd_poechos;
use bd_poechos;

-- -------------------- TABLA PROVEEDOR--------------------------
CREATE TABLE tb_proveedor (
    id_proveedor int NOT NULL AUTO_INCREMENT,
    nombre_proveedor varchar(40) NOT NULL,
    ruc varchar(11) NOT NULL UNIQUE,
    estado CHAR(1) NOT NULL,
    fecha_creada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizada TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    primary key(id_proveedor)
);

-- -------------------- TABLA UNIDAD--------------------------
CREATE TABLE tb_unidad_medida (
    id_unidad_medida int NOT NULL AUTO_INCREMENT,
    unidad_medida varchar(10) NOT NULL,
    descripcion LONGTEXT NOT NULL,
    estado CHAR(1) NOT NULL,
    fecha_creada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizada TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    primary key(id_unidad_medida)
);
-- -------------------- TABLA CATEGORIA ------------------------------
CREATE TABLE tb_categoria_producto (
    id_categoria_producto int NOT NULL AUTO_INCREMENT,
    nombre_categoria varchar(30) NOT NULL,
    descripcion LONGTEXT NOT NULL,
    estado CHAR(1) NOT NULL,
    fecha_creada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizada TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Primary key(id_categoria_producto)
);
-- -------------------- TABLA PRODUCTOS--------------------------
CREATE TABLE tb_producto (
    id_producto int NOT NULL,
    nombre_producto varchar(40) NOT NULL,
    precio_unitario float NOT NULL,
    cantidad int NOT NULL,
    id_categoria_producto int NULL,
    id_proveedor int NULL,
    id_unidad_medida int NOT NULL,
    estado CHAR(1) NOT NULL,
    fecha_creada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizada TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    primary key(id_producto),
    foreign key (id_unidad_medida) references tb_unidad_medida(id_unidad_medida),
    foreign key (id_proveedor) references tb_proveedor(id_proveedor),
    foreign key (id_categoria_producto) references tb_categoria_producto(id_categoria_producto)
);

/* 
INSERT INTO tb_unidad_medida
VALUES 
    (NULL, 'Unidad01', 'Desc..', '1', NULL, NULL),
    (NULL, 'Unidad02', 'Desc..', '1', NULL, NULL),
    (NULL, 'Unidad03', 'Desc..', '1', NULL, NULL),
    (NULL, 'Unidad04', 'Desc..', '1', NULL, NULL),
    (NULL, 'Unidad05', 'Desc..', '1', NULL, NULL);

INSERT INTO tb_categoria_producto
VALUES 
    (NULL, 'cate_01', 'Desc..', '1', NULL, NULL),
    (NULL, 'cate_02', 'Desc..', '1', NULL, NULL),
    (NULL, 'cate_03', 'Desc..', '1', NULL, NULL),
    (NULL, 'cate_04', 'Desc..', '1', NULL, NULL),
    (NULL, 'cate_05', 'Desc..', '1', NULL, NULL);

INSERT INTO tb_proveedor
VALUES 
    (NULL, 'prove_01', '10000000001', '1', NULL, NULL),
    (NULL, 'prove_02', '10000000002', '1', NULL, NULL),
    (NULL, 'prove_03', '10000000003', '1', NULL, NULL),
    (NULL, 'prove_04', '10000000004', '1', NULL, NULL);

INSERT INTO tb_producto
VALUES 
    (NULL, 'produc_01', 10.5, 0, 1, 1, 1 , '1', NULL, NULL),
    (NULL, 'produc_02', 10.5, 0, 1, 1, 1 , '1', NULL, NULL),
    (NULL, 'produc_03', 10.5, 0, 1, 1, 1 , '1', NULL, NULL),
    (NULL, 'produc_04', 10.5, 0, 1, 1, 1 , '1', NULL, NULL);

*/

    