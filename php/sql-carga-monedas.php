<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'conexion-bd.php';

	$query = "SELECT mn_codigo, mn_nombre FROM moneda ORDER BY mn_nombre ASC";
	$result = pg_query($conn, $query);

	if (!$result) {
		http_response_code(500);
		echo json_encode(['error' => 'Error al consultar monedas']);
		exit;
	}

	$monedas = [];
	while ($fila = pg_fetch_assoc($result)) {
		$monedas[] = [
			'mn_codigo' => $fila['mn_codigo'],
			'mn_nombre' => $fila['mn_nombre']
		];
	}

	echo json_encode($monedas);
?>
