document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modalUnidad");
    const btnAbrir = document.getElementById("btnAbrirModal");
    const btnCerrar = document.getElementById("cerrarModal");
    const form = document.getElementById("formUnidad");

    // Crear un campo oculto para el id (para edición)
    let inputId = document.getElementById("id_unidad");
    if (!inputId) {
        inputId = document.createElement("input");
        inputId.type = "hidden";
        inputId.name = "id_unidad";
        inputId.id = "id_unidad";
        form.appendChild(inputId);
    }

    // Abrir modal para crear nueva unidad
    btnAbrir.addEventListener("click", () => {
        form.reset();
        inputId.value = "";
        modal.querySelector("h3").textContent = "Nueva Unidad";
        modal.classList.add("open");
    });

    // Abrir modal para editar unidad
    document.addEventListener("click", (e) => {
        if (e.target && e.target.matches(".btn-editar")) {
            const btn = e.target;

            inputId.value = btn.dataset.id || "";
            document.getElementById("placa").value = btn.dataset.placa || "";
            document.getElementById("marca").value = btn.dataset.marca || "";
            document.getElementById("modelo").value = btn.dataset.modelo || "";
            document.getElementById("anio").value = btn.dataset.anio || "";
            document.getElementById("capacidad_toneladas").value = btn.dataset.capacidad || "";
            document.getElementById("kilometraje").value = btn.dataset.kilometraje || "0";
            document.getElementById("fecha_ultimo_mantenimiento").value = btn.dataset.fecha || "";
            document.getElementById("consumo_combustible").value = btn.dataset.consumo || "";
            document.getElementById("estado").value = btn.dataset.estado || "";

            modal.querySelector("h3").textContent = "Editar Unidad";
            modal.classList.add("open");
        }
    });

    // Cerrar modal
    btnCerrar.addEventListener("click", () => modal.classList.remove("open"));
    window.addEventListener("click", (e) => {
        if (e.target === modal) modal.classList.remove("open");
    });

});
