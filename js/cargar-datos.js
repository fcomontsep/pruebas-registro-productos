document.addEventListener("DOMContentLoaded", function () {
	cargarSelect("php/sql-carga-monedas.php", "moneda", "mn_codigo", "mn_nombre");
	cargarSelect("php/sql-carga-bodegas.php", "bodega", "bd_codigo", "bd_nombre");

	// RECARGAR SUCURSALES AL OCURRIR CAMBIOS EN LA SELECCIÓN DE BODEGA.

	document.getElementById("bodega").addEventListener("change", function () {
		cargarSucursalPorBodega(this.value);
	});
});

async function cargarSelect(url, selectId, valueKey, textKey) {
	try {
		const res = await fetch(url);
		const datos = await res.json();

		// COMENZAR EN BLANCO LA SELECCIÓN; AGREGAR ITEMS EXISTENTES EN LA BASE DE DATOS.

		const select = document.getElementById(selectId);
		select.innerHTML = '<option value="" selected hidden></option>';

		datos.forEach((item) => {
			const option = document.createElement("option");
			option.value = item[valueKey];
			option.textContent = item[textKey];
			select.appendChild(option);
		});
	} catch (err) {
		console.error(`Error al cargar ${selectId}:`, err);
	}
}

async function cargarSucursalPorBodega(bdCodigo, selectId = "sucursal") {
	const selectSucursal = document.getElementById(selectId);
	selectSucursal.innerHTML = '<option value="" selected hidden></option>';

	// SI UNA BODEGA NO CUENTA CON SUCURSALES, FINALIZAR AQUÍ.

	if (!bdCodigo) return;

	try {
		const res = await fetch("php/sql-carga-sucursal.php", {
			method: "POST",
			headers: { "Content-Type": "application/x-www-form-urlencoded" },
			body: "bd_codigo=" + encodeURIComponent(bdCodigo),
		});
		const sucursales = await res.json();

		sucursales.forEach((sucursal) => {
			const option = document.createElement("option");
			option.value = sucursal.sc_codigo;
			option.textContent = sucursal.sc_nombre;
			selectSucursal.appendChild(option);
		});
	} catch (err) {
		console.error("Error al cargar sucursales:", err);
	}
}
