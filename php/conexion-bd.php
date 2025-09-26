<?php
	require_once 'cargar-env.php';
	cargarEnv();

	// CONEXIÓN A LA BASE DE DATOS POSTGRESQL.
	$conn = pg_connect(sprintf(
		"host=%s port=%s dbname=%s user=%s password=%s",
		getenv('PG_HOST'),
		getenv('PG_PORT'),
		getenv('PG_DBNAME'),
		getenv('PG_USER'),
		getenv('PG_PASSWORD')
	));

	if (!$conn) {
		die("Error de conexión a PostgreSQL. Verifica .env y la configuración de tu instalación.");
	}

	// SI SE LLEGA AQUÍ, LA CONEXIÓN HA SIDO EXITOSA.
	// CONECTARSE MEDIANTE $conn.
?>