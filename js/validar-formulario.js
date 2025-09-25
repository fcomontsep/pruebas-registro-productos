document.addEventListener("DOMContentLoaded", function () {
	const formulario = document.getElementById("formulario-producto");

	formulario.addEventListener("submit", function (e) {
		// VALIDACIÓN DEL CÓDIGO ENTREGADO AL FORMULARIO.
		// PENDIENTE - VALIDAR QUE NO EXISTA PREVIAMENTE EN LA BASE DE DATOS.
		const codigo = document.getElementById("codigo").value.trim();
		const regexCodigo = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/;
		if (codigo === "") {
			e.preventDefault();
			alert("El código del producto no puede estar en blanco.");
			document.getElementById("codigo").focus();
			return;
		} else if (!regexCodigo.test(codigo)) {
			e.preventDefault();
			alert("El código del producto debe contener letras y números.");
			document.getElementById("codigo").focus();
			return;
		} else if (codigo.length < 5 || codigo.length > 15) {
			e.preventDefault();
			alert("El código del producto debe tener entre 5 y 15 caracteres.");
			document.getElementById("codigo").focus();
			return;
		}
		
		// VALIDACIÓN DEL NOMBRE ENTREGADO AL FORMULARIO.
		const nombre = document.getElementById("nombre").value.trim();
		if (nombre === "") {
			e.preventDefault();
			alert("El nombre del producto no puede estar en blanco.");
			document.getElementById("nombre").focus();
			return;
		} else if (nombre.length < 2 || nombre.length > 50) {
			e.preventDefault();
			alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
			document.getElementById("nombre").focus();
			return;
		}

		// VALIDACIÓN DEL PRECIO DEL PRODUCTO.
		const precio = document.getElementById("precio").value.trim();
		const regexPrecio = /^(?!0+(?:\.0+)?$)\d+(\.\d{1,2})?$/;
		if (precio === "") {
			e.preventDefault();
			alert("El precio del producto no puede estar en blanco.");
			document.getElementById("precio").focus();
			return;
		} else if (!regexPrecio.test(precio)) {
			e.preventDefault();
			alert("El precio del producto debe ser un número positivo con hasta dos decimales.");
			document.getElementById("precio").focus();
			return;
		}

		// VALIDACIÓN DE LOS MATERIALES SELECCIONADOS.
		const materialesSeleccionados = document.querySelectorAll('input[name="material[]"]:checked');
		if (materialesSeleccionados.length < 2) {
			e.preventDefault();
			alert("Debe seleccionar al menos dos materiales para el producto.");
			return;
		}

		// VALIDACIÓN DE LA BODEGA.
		const bodega = document.getElementById("bodega").value;
		if (bodega === "") {
			e.preventDefault();
			alert("Debe seleccionar una bodega.");
			document.getElementById("bodega").focus();
			return;
		}

		// VALIDACIÓN DE LA SUCURSAL.
		const sucursal = document.getElementById("sucursal").value;
		if (sucursal === "") {
			e.preventDefault();
			alert("Debe seleccionar una sucursal para la bodega seleccionada.");
			document.getElementById("sucursal").focus();
			return;
		}

		// VALIDACIÓN DE LA MONEDA.
		const moneda = document.getElementById("moneda").value;
		if (moneda === "") {
			e.preventDefault();
			alert("Debe seleccionar una moneda para el producto.");
			document.getElementById("moneda").focus();
			return;
		}

		// VALIDACIÓN DE LA DESCRIPCIÓN.
		const descripcion = document.getElementById("descripcion").value.trim();
		if (descripcion === "") {
			e.preventDefault();
			alert("La descripción del producto no puede estar en blanco.");
			document.getElementById("descripcion").focus();
			return;
		} else if (descripcion.length < 10 || descripcion.length > 1000) {
			e.preventDefault();
			alert("La descripción del producto debe tener entre 10 y 1000 caracteres.");
			document.getElementById("descripcion").focus();
			return;
		}
	});
});
