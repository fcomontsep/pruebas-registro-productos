<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'conexion-bd.php';

	$bd_codigo = $_POST['bd_codigo'] ?? '';

	if (!$bd_codigo) {
		http_response_code(400);
		echo json_encode(['error' => 'Código de bodega no recibido']);
		exit;
	}

	$query = "SELECT sc_codigo, sc_nombre FROM sucursal WHERE bd_codigo = $1 ORDER BY sc_nombre ASC";
	$result = pg_query_params($conn, $query, [$bd_codigo]);

	if (!$result) {
		http_response_code(500);
		echo json_encode(['error' => 'Error al consultar sucursales']);
		exit;
	}

	$sucursales = [];
	while ($fila = pg_fetch_assoc($result)) {
		$sucursales[] = [
			'sc_codigo' => $fila['sc_codigo'],
			'sc_nombre' => $fila['sc_nombre']
		];
	}

	echo json_encode($sucursales);
?>
