document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("modalChofer");
    const btnAbrir = document.getElementById("btnAbrirModal");
    const btnCerrar = document.getElementById("cerrarModal");
    const form = document.getElementById("formChofer");

    // Abrir modal
    btnAbrir.addEventListener("click", () => {
        form.reset();
        document.getElementById("id_chofer").value = "";
        modal.style.display = "block";
        document.getElementById("tituloModal").textContent = "Nuevo Chofer";
    });

    // Cerrar modal
    btnCerrar.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Editar chofer
    document.querySelectorAll(".btn-editar").forEach(btn => {
        btn.addEventListener("click", function() {
            const id = this.dataset.id;
            document.getElementById("id_chofer").value = id;
            document.getElementById("nombre").value = this.dataset.nombre;
            document.getElementById("dpi").value = this.dataset.dpi;
            document.getElementById("telefono").value = this.dataset.telefono;
            document.getElementById("direccion").value = this.dataset.direccion;
            document.getElementById("licencia").value = this.dataset.licencia;
            document.getElementById("activo").checked = this.dataset.activo === "1";

            document.getElementById("tituloModal").textContent = "Editar Chofer";
            modal.style.display = "block";
        });
    });

    // Cerrar modal al click fuera
    window.addEventListener("click", (e) => {
        if (e.target === modal) modal.style.display = "none";
    });
});
