document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modalUsuario");
    const btnAbrir = document.getElementById("btnAbrirModal");
    const btnCerrar = document.getElementById("cerrarModal");
    const form = document.getElementById("formUsuario");
    const tituloModal = document.getElementById("tituloModal");
    const btnGuardar = document.getElementById("btnGuardar");

    // Abrir modal para crear
    btnAbrir.addEventListener("click", () => {
        form.reset();
        document.getElementById("id_usuario").value = "";
        tituloModal.textContent = "Nuevo Usuario";
        btnGuardar.textContent = "Crear usuario";
        openModal();
    });

    // Cerrar modal
    btnCerrar.addEventListener("click", closeModal);
    window.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    // Función abrir/cerrar
    function openModal() {
        modal.classList.add("open");
        modal.setAttribute("aria-hidden", "false");
    }
    function closeModal() {
        modal.classList.remove("open");
        modal.setAttribute("aria-hidden", "true");
    }

    // Delegación para botones de editar (en la tabla)
    document.addEventListener("click", (e) => {
        if (e.target && e.target.matches(".btn-editar")) {
            const btn = e.target;
            document.getElementById("id_usuario").value = btn.dataset.id || "";
            document.getElementById("nombre_usuario").value = btn.dataset.usuario || "";
            document.getElementById("nombre_completo").value = btn.dataset.nombre || "";
            document.getElementById("correo").value = btn.dataset.correo || "";
            document.getElementById("id_rol").value = btn.dataset.rol || "";
            document.getElementById("activo").checked = btn.dataset.activo === "1";
            document.getElementById("password").value = "";

            tituloModal.textContent = "Editar Usuario";
            btnGuardar.textContent = "Actualizar usuario";
            openModal();
        }
    });

    // Validación mínima antes de enviar (form submit tradicional)
    if (form) {
        form.addEventListener("submit", (e) => {
            const id = document.getElementById("id_usuario").value.trim();
            const pass = document.getElementById("password").value.trim();

            // Si es creación (no id) exigir contraseña >= 6
            if (!id && pass.length < 6) {
                e.preventDefault();
                alert("La contraseña debe tener al menos 6 caracteres para nuevos usuarios.");
                return false;
            }

            // opcional: validar email y campos
            return true; // permitir envío normal
        });
    }

});
