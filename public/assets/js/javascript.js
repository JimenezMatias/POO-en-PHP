// Seleccionamos elementos
const modalClientes = document.getElementById("modal-clientes");
const btnClientes = document.getElementById("btn-clientes");
const closeModal = document.querySelector("#modal-clientes .close");

const formClientes = document.getElementById("form-clientes");
const tablaClientes = document.getElementById("tabla-clientes");
const btnEditar = document.getElementById("btn-editar");

// Abrir modal al hacer click en Clientes
btnClientes.addEventListener("click", function(event) {
  event.preventDefault(); 
  modalClientes.style.display = "flex"; 
  formClientes.style.display = "block"; // aseguramos que el formulario esté visible
  tablaClientes.style.display = "none"; // tabla oculta al abrir
});

// Cerrar modal con la X
closeModal.addEventListener("click", function() {
  modalClientes.style.display = "none";
});

// Cerrar modal si el usuario hace click fuera del contenido
window.addEventListener("click", function(event) {
  if (event.target === modalClientes) {
    modalClientes.style.display = "none";
  }
});

// Mostrar tabla al hacer click en Editar
btnEditar.addEventListener("click", function() {
  formClientes.style.display = "none";
  tablaClientes.style.display = "table";
});

// Al hacer click en una fila de la tabla, cargar datos en el formulario
tablaClientes.addEventListener("click", function(e) {
  const fila = e.target.closest("tr");
  if (!fila || fila.querySelector("th")) return; // ignorar encabezados

  const nombre = fila.cells[1].textContent;
  const email = fila.cells[2].textContent;

  // Cargar datos en el formulario
  document.getElementById("nombre").value = nombre;
  document.getElementById("email").value = email;

  // Mostrar formulario y ocultar tabla
  formClientes.style.display = "block";
  tablaClientes.style.display = "none";
});


document.addEventListener("DOMContentLoaded", () => {
  const dropdowns = document.querySelectorAll(".dropdown");

  dropdowns.forEach(dropdown => {
    const toggleBtn = dropdown.querySelector(".menu-btn");
    const menu = dropdown.querySelector(".dropdown-menu");

    toggleBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      // Cerrar otros abiertos
      document.querySelectorAll(".dropdown-menu.show").forEach(m => {
        if (m !== menu) m.classList.remove("show");
      });
      menu.classList.toggle("show");
    });

    document.addEventListener("click", (e) => {
      if (!dropdown.contains(e.target)) {
        menu.classList.remove("show");
      }
    });
  });
});


