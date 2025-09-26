<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'conexion-bd.php';

	$query = "SELECT bd_codigo, bd_nombre FROM bodega ORDER BY bd_nombre ASC";
	$result = pg_query($conn, $query);

	if (!$result) {
		http_response_code(500);
		echo json_encode(['error' => 'Error al consultar bodegas']);
		exit;
	}

	$bodegas = [];
	while ($fila = pg_fetch_assoc($result)) {
		$bodegas[] = [
			'bd_codigo' => $fila['bd_codigo'],
			'bd_nombre' => $fila['bd_nombre']
		];
	}

	echo json_encode($bodegas);
?>
