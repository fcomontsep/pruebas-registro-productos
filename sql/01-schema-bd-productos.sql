----- CREACIÓN DE TABLAS REQUERIDAS POR EL SISTEMA.

CREATE TABLE moneda (
  mn_codigo SERIAL PRIMARY KEY,
  mn_nombre VARCHAR(50) NOT NULL
);

CREATE TABLE bodega (
  bd_codigo SERIAL PRIMARY KEY,
  bd_nombre VARCHAR(100) NOT NULL
);

CREATE TABLE sucursal (
  sc_codigo SERIAL PRIMARY KEY,
  sc_nombre VARCHAR(100) NOT NULL,
  bd_codigo INTEGER NOT NULL,
  FOREIGN KEY (bd_codigo) REFERENCES bodega(bd_codigo)
);

CREATE TABLE material (
  mt_codigo SERIAL PRIMARY KEY,
  mt_nombre VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE producto (
  pd_codigo VARCHAR(15) PRIMARY KEY CHECK (char_length(pd_codigo) BETWEEN 5 AND 15),
  pd_nombre VARCHAR(50) NOT NULL CHECK (char_length(pd_nombre) BETWEEN 2 AND 50),
  pd_precio NUMERIC(12,2) CHECK (pd_precio > 0),
  pd_descripcion TEXT CHECK (char_length(pd_descripcion) BETWEEN 10 AND 1000),
  mn_codigo INTEGER NOT NULL,
  bd_codigo INTEGER NOT NULL,
  sc_codigo INTEGER NOT NULL,
  FOREIGN KEY (mn_codigo) REFERENCES moneda(mn_codigo),
  FOREIGN KEY (bd_codigo) REFERENCES bodega(bd_codigo),
  FOREIGN KEY (sc_codigo) REFERENCES sucursal(sc_codigo)
);

CREATE TABLE componente (
  pd_codigo VARCHAR(15) NOT NULL,
  mt_codigo INTEGER NOT NULL,
  PRIMARY KEY (pd_codigo, mt_codigo),
  FOREIGN KEY (pd_codigo) REFERENCES producto(pd_codigo),
  FOREIGN KEY (mt_codigo) REFERENCES material(mt_codigo)
);

----- CREACIÓN DE DATOS BÁSICOS SEGÚN EJEMPLO ENTREGADO.

INSERT INTO bodega (bd_nombre) VALUES
('Bodega 1'),
('Bodega 2');

INSERT INTO sucursal (sc_nombre, bd_codigo) VALUES
('Sucursal 1', 1),
('Sucursal 2', 1),
('Centro 1', 2),
('Centro 2', 2);

INSERT INTO moneda (mn_nombre) VALUES
('DÓLAR'),
('PESO CHILENO');

INSERT INTO material (mt_nombre) VALUES
('Plástico'),
('Metal'),
('Madera'),
('Vidrio'),
('Textil');