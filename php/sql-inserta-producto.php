<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'conexion-bd.php';

 	// SE CAPTURAN LOS DATOS O SE ASIGNA UN DATO POR DEFECTO.
	$codigo      = $_POST['codigo']      ?? '';
	$nombre      = $_POST['nombre']      ?? '';
	$precio      = $_POST['precio']      ?? '';
	$descripcion = $_POST['descripcion'] ?? '';
	$moneda      = $_POST['moneda']      ?? '';
	$bodega      = $_POST['bodega']      ?? '';
	$sucursal    = $_POST['sucursal']    ?? '';
	$materiales  = $_POST['material']    ?? []; // ARREGLO DE CÓDIGOS (DOS O MÁS ELEMENTOS).

	// VALIDACIÓN MÍNIMA EN EL BACK END.
	if (!$codigo || !$nombre || !$precio || !$descripcion || !$moneda || !$bodega || !$sucursal || count($materiales) < 2) {
		http_response_code(400);
		echo json_encode(['error' => 'Faltan datos obligatorios o materiales insuficientes']);
		exit;
	}

	// INICIO DE TRANSACCIÓN, BUSCANDO ASEGURAR QUE NO QUEDEN PRODUCTOS SIN MATERIALES O VICEVERSA.
	pg_query($conn, "BEGIN");

	// INSERTA EL PRODUCTO.
	$query = "INSERT INTO producto (pd_codigo, pd_nombre, pd_precio, pd_descripcion, mn_codigo, bd_codigo, sc_codigo) VALUES ($1, $2, $3, $4, $5, $6, $7)";
	$result = pg_query_params($conn, $query, [$codigo, $nombre, $precio, $descripcion, $moneda, $bodega, $sucursal]);

	if (!$result) {
		pg_query($conn, "ROLLBACK");
		http_response_code(500);
		echo json_encode(['error' => 'Error al insertar producto: ' . pg_last_error($conn)]);
		exit;
	}

	// INSERTA LOS MATERIALES ASOCIADOS. BÚSCALOS POR NOMBRE EN LA BD Y RECUPERA SUS IDS.
	foreach ($materiales as $mt_nombre) {
		$queryBuscar = "SELECT mt_codigo FROM material WHERE mt_nombre = $1 LIMIT 1";
		$resBuscar = pg_query_params($conn, $queryBuscar, [$mt_nombre]);

		if (!$resBuscar || pg_num_rows($resBuscar) === 0) {
			pg_query($conn, "ROLLBACK");
			http_response_code(500);
			echo json_encode(['error' => "Material '$mt_nombre' no encontrado"]);
			exit;
		}
		$mt_codigo = pg_fetch_result($resBuscar, 0, 'mt_codigo');
		
		$queryMat = "INSERT INTO componente (pd_codigo, mt_codigo) VALUES ($1, $2)";
		$resultMat = pg_query_params($conn, $queryMat, [$codigo, $mt_codigo]);

		if (!$resultMat) {
			pg_query($conn, "ROLLBACK");
			http_response_code(500);
			echo json_encode(['error' => 'Error al insertar componente: ' . pg_last_error($conn)]);
			exit;
		}
	}

	// CONFIRMA LA TRANSACCIÓN.
	pg_query($conn, "COMMIT");
	echo json_encode(['exito' => true]);
?>
