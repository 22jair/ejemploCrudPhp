use model;
drop database bd_poechos;

----------------------------------------------------------------------------------
---------------------- CREACI�N DE LA BASE DE DATOS ------------------------------
----------------------------------------------------------------------------------
CREATE DATABASE bd_poechos;
use bd_poechos;

----------------------------------------------------------------------------------
---------------------- CREACI�N DE TABLAS PRINCIPALES ----------------------------
----------------------------------------------------------------------------------

---------------------- TABLA ALMACEN --------------------------
CREATE TABLE tb_almacen
(
id_almacen int NOT NULL, 
nombre_almacen varchar(40)  NOT NULL,
primary key(id_almacen)
)

---------------------- TABLA ESTANTE --------------------------
CREATE TABLE tb_estante
(
id_estante int NOT NULL, 
descripcion varchar(10)  NOT NULL,
fk_almacen int NOT NULL,
primary key(id_estante),
foreign key(fk_almacen) references tb_almacen(id_almacen)
)

---------------------- TABLA PRODUCTO_ESTANTE --------------------------
CREATE TABLE tb_producto_estante
(
id_producto_estante int NOT NULL, 
descripcion varchar(10)  NOT NULL,
fk_estante int NOT NULL,
primary key(id_producto_estante),
foreign key(fk_estante) references tb_estante(id_estante)
);

---------------------- TABLA PROVEEDOR--------------------------
CREATE TABLE tb_proveedor
(
  id_proveedor int NOT NULL,
  nombre_proveedor varchar(40) NOT NULL,
  ruc varchar(11) NOT NULL,
  primary key(id_proveedor)
);

---------------------- TABLA UNIDAD--------------------------

CREATE TABLE tb_unidad_medida_producto
(
id_unidad_medida_producto int NOT NULL, 
descripcion varchar(40)  NOT NULL,
primary key(id_unidad_medida_producto)
);

 ---------------------- TABLA CATEGORIA ------------------------------
CREATE TABLE tb_categoria_producto
(   
    id_categoria_producto int NOT NULL,
    nombre_categoria  varchar(30)  NOT NULL,
    descripcion  varchar(30)  NOT NULL,
	estado bit NOT NULL,
	Primary key(id_categoria_producto)
);


---------------------- TABLA PRODUCTOS--------------------------
CREATE TABLE tb_producto
(
id_producto int NOT NULL, 
nombre_productos varchar(40)  NOT NULL,
precio_unitario float NOT NULL,
cantidad int NOT NULL,
fk_categoria_producto int NULL,
fk_proveedor int NULL,
fk_unidad_medida int NOT NULL,
fk_producto_estante int NOT NULL,
primary key(id_producto),
foreign key (fk_unidad_medida) references tb_unidad_medida_producto(id_unidad_medida_producto),
foreign key (fk_proveedor) references tb_proveedor(id_proveedor),
foreign key (fk_categoria_producto) references tb_categoria_producto(id_categoria_producto),
foreign key (fk_producto_estante) references tb_producto_estante(id_producto_estante)
);


---------------------- TABLA ROL --------------------------
CREATE TABLE tb_rol
(
id_rol int NOT NULL, 
nombre_rol varchar(40)  NOT NULL,
descripcion_rol varchar(40)  NOT NULL,
estado_rol bit NOT NULL,
primary key(id_rol)
);
---------------------- TABLA CARGA --------------------------
CREATE TABLE tb_cargo_persona
(
id_cargo_persona int NOT NULL, 
descripcion varchar(40)  NOT NULL,
primary key(id_cargo_persona)
);


---------------------- TABLA PERSONA --------------------------
CREATE TABLE tb_persona
(
id_persona int NOT NULL, 
nombre_persona varchar(40)  NOT NULL,
apellidos_persona varchar(40)  NOT NULL,
dni_persona varchar(8) NOT NULL,
telefono varchar(9) NOT NULL,
fk_cargo int NOT NULL,
primary key(id_persona),
foreign key(fk_cargo) references tb_cargo_persona(id_cargo_persona)
);

---------------------- TABLA USUARIO --------------------------
CREATE TABLE tb_usuario
(
id_usuario int NOT NULL, 
usuario_acceso varchar(15) NOT NULL,
clave_acceso varchar(30) NOT NULL,
primary key(id_usuario),
fk_rol int NOT NULL,
fk_persona int NOT NULL,
foreign key(fk_rol) references tb_rol(id_rol),
foreign key(fk_persona) references tb_persona(id_persona)
);



---------------------- TABLA ENTRADA --------------------------
CREATE TABLE tb_entrada_producto
(
id_entrada_producto int NOT NULL, 
fecha date NOT NULL,
total float NOT NULL,
nombre_almacen varchar(40)  NOT NULL,
fk_usuario int NOT NULL,
primary key(id_entrada_producto),
foreign key(fk_usuario) references tb_usuario(id_usuario)
);

---------------------- TABLA ACTIVIDAD --------------------------
CREATE TABLE tb_actividad
(
id_actividad int NOT NULL, 
descripcion varchar(40)  NOT NULL,
primary key(id_actividad)
);


---------------------- TABLA SALIDA --------------------------
CREATE TABLE tb_salida_producto
(
id_salida_producto int NOT NULL, 
fecha date NOT NULL,
total float NOT NULL,
fk_persona int NOT NULL,
fk_actividad int NOT NULL,
primary key(id_salida_producto),
foreign key(fk_persona) references tb_persona(id_persona),
foreign key(fk_actividad) references tb_actividad(id_actividad)
);

---------------------- TABLA DETALLE_ENTRADA --------------------------
CREATE TABLE tb_detalle_entrada_producto
(
id_detalle_entrada_producto int NOT NULL, 
cantidad int NOT NULL,
fk_entrada int NOT NULL,
fk_producto int NOT NULL,
precio float NOT NULL,
primary key(id_detalle_entrada_producto),
foreign key (fk_entrada) references tb_entrada_producto(id_entrada_producto),
foreign key (fk_producto) references tb_producto(id_producto)
);

---------------------- TABLA DETALLE_SALIDA --------------------------
CREATE TABLE tb_detalle_salida_producto
(
id_detalle_salida_producto int NOT NULL, 
cantidad int NOT NULL,
fk_salida int NOT NULL,
fk_producto int NOT NULL,
precio float NOT NULL,
primary key(id_detalle_salida_producto),
foreign key (fk_salida) references tb_salida_producto(id_salida_producto),
foreign key (fk_producto) references tb_producto(id_producto)
);


---------------------- TABLA TIPO_VEHICULO --------------------------
CREATE TABLE tb_tipo_vehiculo
(
id_tipo_vehiculo int NOT NULL, 
descripcion varchar(40) NULL,
primary key(id_tipo_vehiculo)
);


---------------------- TABLA VEHICULO--------------------------
CREATE TABLE tb_vehiculo
(
id_vehiculo int NOT NULL, 
placa varchar(6)  NOT NULL,
kilometraje varchar NOT NULL,
modelo varchar(30) NOT NULL,
fk_tipo_vehiculo int NOT NULL,
primary key(id_vehiculo),
foreign key (fk_tipo_vehiculo) references tb_tipo_vehiculo(id_tipo_vehiculo)
);


---------------------- TABLA COMBUSTIBLE --------------------------
CREATE TABLE tb_combustible
(
id_combustible int NOT NULL, 
descripcion varchar NOT NULL,
galones varchar NOT NULL,
precio float NOT NULL,
primary key(id_combustible)
);


---------------------- TABLA DETALLE_SALIDA_COMBUSTIBLE --------------------------
CREATE TABLE tb_detalle_salida_combustible
(
id_detalle_salida_combustible int NOT NULL, 
fk_combustible int NOT NULL,
galones_despachados int NOT NULL,
fk_vehiculo int NOT NULL,
fk_conductor int NOT NULL,
fecha_salida_combustible date,
precio_total float NOT NULL,
primary key(id_detalle_salida_combustible),
foreign key (fk_combustible) references tb_combustible(id_combustible),
foreign key (fk_vehiculo) references tb_vehiculo(id_vehiculo),
foreign key (fk_conductor) references tb_persona(id_persona)
);

---------------------- TABLA DETALLE_ENTRADA_COMBUSTIBLE --------------------------

CREATE TABLE tb_detalle_entrada_combustible
(
id_detalle_entrada_combustible int NOT NULL, 
fk_combustible int NOT NULL,
galones_ingresados int NOT NULL,
fecha_entrada_combustible date,
precio_por_galon float NOT NULL,
precio_total float NOT NULL,
fk_usuario int NOT NULL,
primary key(id_detalle_entrada_combustible),
foreign key (fk_combustible) references tb_combustible(id_combustible),
foreign key (fk_usuario) references tb_usuario(id_usuario)

);

