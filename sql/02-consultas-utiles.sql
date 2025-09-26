----- CREACIÓN DE PRODUCTOS DE PRUEBA CON LAS COLUMNAS REQUERIDAS. SE LES ASOCIA COMPONENTES DE MATERIALES.

INSERT INTO producto (
  pd_codigo, pd_nombre, pd_precio, pd_descripcion,
  mn_codigo, bd_codigo, sc_codigo
) VALUES
('PROD03A', 'Juego Living', 3000.00,
  'Elegante set de living.',
  1, 1, 2),

  ('PROD0252I', 'Televisión moderna', 900000.00,
  'Televisión de última generación con tecnología que simplemente no puedes perderte.',
  2, 2, 3);

INSERT INTO componente (pd_codigo, mt_codigo) VALUES
('PROD03A', 3),
('PROD03A', 5);

INSERT INTO componente (pd_codigo, mt_codigo) VALUES
('PROD0252I', 1),
('PROD0252I', 2);

----- SELECCIÓN DE PRODUCTOS, DE COMPONENTES, Y DE PRODUCTOS CON CADA COLUMNA DE INTERÉS ASOCIADA A ESTOS.

SELECT * FROM producto;
SELECT * FROM componente;

SELECT 
  p.pd_codigo,
  p.pd_nombre,
  p.pd_precio,
  p.pd_descripcion,
  m.mn_nombre AS moneda,
  b.bd_nombre AS bodega,
  s.sc_nombre AS sucursal,
  STRING_AGG(mat.mt_nombre, ', ') AS materiales
FROM producto p
JOIN moneda m ON p.mn_codigo = m.mn_codigo
JOIN bodega b ON p.bd_codigo = b.bd_codigo
JOIN sucursal s ON p.sc_codigo = s.sc_codigo
JOIN componente c ON p.pd_codigo = c.pd_codigo
JOIN material mat ON c.mt_codigo = mat.mt_codigo
GROUP BY 
  p.pd_codigo, p.pd_nombre, p.pd_precio, p.pd_descripcion,
  m.mn_nombre, b.bd_nombre, s.sc_nombre
ORDER BY p.pd_codigo;

----- PARA PODER LIMPIAR DISTINTOS DATOS Y SEGUIR PROBANDO. CUIDADO.

TRUNCATE TABLE sucursal, bodega RESTART IDENTITY CASCADE;
TRUNCATE TABLE 
  componente,
  producto,
  material,
  sucursal,
  bodega,
  moneda
RESTART IDENTITY CASCADE;