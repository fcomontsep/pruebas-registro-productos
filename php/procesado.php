<?php
	require_once 'conexion-bd.php';

	// PRUEBA CON LA EXTRACCIÓN DE LA HORA ACTUAL EN POSTGRESQL.
	$resultado = pg_query($conn, "SELECT NOW()");
	$fila = pg_fetch_assoc($resultado);
	echo "Hora actual en PostgreSQL: " . $fila['now'];
	
?>