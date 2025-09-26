<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'conexion-bd.php';
	$codigo = $_POST['codigo'] ?? '';
		
	// REDUNDANCIA EN CASO DE QUE HAYAN PROBLEMAS CON JAVASCRIPT.
	if (!$codigo) {
		http_response_code(400);
		echo json_encode(['error' => 'El código del producto no puede estar en blanco.']);
		exit;
	}

	$query = "SELECT 1 FROM producto WHERE pd_codigo = $1 LIMIT 1";
	$result = @pg_query_params($conn, $query, [$codigo]);

	if ($result === false) {
		http_response_code(500);
		echo json_encode(['error' => 'Error interno en la verificación del código.']);
		exit;
	}

	echo json_encode(['existe' => pg_num_rows($result) > 0]);
?>