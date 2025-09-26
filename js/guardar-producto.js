async function guardarProducto() {
	const formulario = document.getElementById("formulario-producto");
	const formData = new FormData(formulario);

	// INSERCIÓN DE DATOS A LA BASE. SE NOTIFICA AL CLIENTE DEL ÉXITO O FRACASO DE ESTE PROCESO.

	try {
		const res = await fetch("php/sql-inserta-producto.php", {
			method: "POST",
			body: formData,
		});
		const resultado = await res.json();

		if (resultado.exito) {
			alert("Producto insertado correctamente.");
			formulario.reset();
		} else {
			alert("Error: " + (resultado.error || "No se pudo insertar el producto."));
		}
	} catch (err) {
		console.error("Error al enviar producto:", err);
		alert("Error inesperado al guardar el producto.");
	}
}
