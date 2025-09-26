<?php
	// FUNCIÓN PARA CARGAR DATOS DE CONTRASEÑA Y BASE DE DATOS DESDE .ENV
	function cargarEnv($ruta = '../.env') {
		if (!file_exists($ruta)) return;

		// SE LEE CADA ARCHIVO LINEA POR LINEA Y SE GUARDA EN UN ARREGLO.
		$lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		foreach ($lineas as $linea) {
			if (strpos(trim($linea), '#') === 0) continue;
			list($clave, $valor) = explode('=', $linea, 2);
			putenv(trim($clave) . '=' . trim($valor));
		}
	}
?>