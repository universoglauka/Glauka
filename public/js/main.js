//----------------------------------------------
// Show user

const selectFuncion = document.getElementById("funcion-select");

if (selectFuncion) {
  const precioUnitario = parseFloat(document.getElementById('precio-unitario').value);

  const cantidadInicial = document.getElementById("cantidad-inicial");

  let cantidadActual = cantidadInicial ? parseInt(cantidadInicial.value) : 0;

  let maxStock = 0;

  // Obtener elementos del DOM
  const selectFuncion = document.getElementById('funcion-select');
  const stockDisplay = document.getElementById('stock-display');
  const cantidadInput = document.getElementById('cantidad-input');
  const formCarrito = document.getElementById('form-carrito');
  const mensajesError = document.getElementById('mensajes-error');
  const btnSubmit = document.getElementById('btn-submit-carrito');
  const mensajeVirtual = document.getElementById('mensaje-virtual');
  const contenedorEmails = document.getElementById('contenedor-emails');
  const inputEmailsIniciales = document.getElementById("emails-iniciales");




  // Inicializar al cargar la página
  document.addEventListener('DOMContentLoaded', function () {
    if (selectFuncion && selectFuncion.options.length > 0) {

      const opcionSeleccionada = selectFuncion.options[selectFuncion.selectedIndex];
      maxStock = parseInt(opcionSeleccionada.dataset.stock);
      stockDisplay.textContent = maxStock;

    } else {
      // Si no hay funciones con stock, desactivamos el botón
      if (btnSubmit) btnSubmit.disabled = true;
      if (stockDisplay) stockDisplay.textContent = "0";
    }

    // Mostrar la cantidad inicial
    document.getElementById("general-quantity").textContent = cantidadActual;
    cantidadInput.value = cantidadActual;

    actualizarCamposEmails();
    actualizarTotal();
  });

  // Escuchar cambios en el selector de función
  selectFuncion.addEventListener('change', function () {
    const opcion = this.options[this.selectedIndex];

    maxStock = parseInt(opcion.dataset.stock);
    stockDisplay.textContent = maxStock;

    const esVirtual = opcion.dataset.virtual === "1";

    if (esVirtual) {
      mensajeVirtual.classList.remove("d-none");
    } else {
      mensajeVirtual.classList.add("d-none");
    }

    if (cantidadActual > maxStock) {
      cantidadActual = maxStock;
    }

    document.getElementById("general-quantity").textContent = cantidadActual;
    cantidadInput.value = cantidadActual;

    actualizarCamposEmails();
    actualizarTotal();
    limpiarMensajesError();
  });

  // Función para actualizar la cantidad de entradas
  function actualizarCantidadDeEntradas(change) {
    const nuevaCantidad = cantidadActual + change;

    if (nuevaCantidad < 0) {
      return;
    }

    if (nuevaCantidad > maxStock) {
      mostrarError('No puedes seleccionar más de ' + maxStock + ' entradas para esta función.');
      return;
    }


    // Actualizar cantidad
    cantidadActual = nuevaCantidad;

    document.getElementById('general-quantity').textContent = cantidadActual;
    cantidadInput.value = cantidadActual;
    actualizarCamposEmails();
    actualizarTotal();
    limpiarMensajesError();
  }

  // Función para calcular y actualizar el total
  function actualizarTotal() {
    const total = cantidadActual * precioUnitario;
    document.getElementById('total-price').textContent = `$ ${total.toFixed(2)}`;
  }


  //Si la función es virtual, mostrar el mensaje y los campos de email
  function actualizarVistaFuncionSeleccionada() {

    const opcion = selectFuncion.options[selectFuncion.selectedIndex];

    maxStock = parseInt(opcion.dataset.stock);

    stockDisplay.textContent = maxStock;

    if (opcion.dataset.virtual === "1") {
      mensajeVirtual.classList.remove("d-none");
    } else {
      mensajeVirtual.classList.add("d-none");
    }

    actualizarCamposEmails();
  }

  document.addEventListener("DOMContentLoaded", function () {
    actualizarVistaFuncionSeleccionada();
  });


  let emailsIniciales = [];

  if (inputEmailsIniciales) {
    emailsIniciales = JSON.parse(inputEmailsIniciales.value);
  }


  // Función para actualizar/rehacer los campos de email según la cantidad de entradas
  function actualizarCamposEmails() {
    const inputsExistentes = contenedorEmails.querySelectorAll('input[type="email"]');

    if (inputsExistentes.length > 0) {
      emailsIniciales = [];

      inputsExistentes.forEach(input => {
        emailsIniciales.push(input.value);
      });
    }

    while (contenedorEmails.firstChild) {
      contenedorEmails.removeChild(contenedorEmails.firstChild);
    }

    const opcion = selectFuncion.options[selectFuncion.selectedIndex];
    const esVirtual = opcion.dataset.virtual === "1";

    if (!esVirtual) {
      return;
    }

    for (let i = 1; i <= cantidadActual; i++) {
      const id = `email-ticket-${i}`;

      const div = document.createElement("div");
      div.classList.add("mb-3");

      const label = document.createElement("label");
      label.classList.add("form-label");
      label.textContent = `Entrada ${i}`;
      label.setAttribute("for", id);

      const input = document.createElement("input");
      input.id = id;

      if (emailsIniciales[i - 1]) {
        input.value = emailsIniciales[i - 1];
      }

      input.setAttribute("type", "email");
      input.setAttribute("name", "emails_virtuales[]");
      input.setAttribute("required", "");
      input.classList.add("form-control");

      div.appendChild(label);
      div.appendChild(input);

      contenedorEmails.appendChild(div);
    }
  }


  // Función para mostrar mensajes de error
  function mostrarError(mensaje) {
    const alertaError = document.getElementById('notificacion-error');
    const textoError = document.getElementById('texto-error');

    textoError.textContent = mensaje;
    alertaError.style.display = 'block';

    // Ocultar automáticamente después de 5 segundos
    setTimeout(() => {
      alertaError.style.display = 'none';
    }, 5000);
  }

  // Función para limpiar
  function limpiarMensajesError() {
    document.getElementById('notificacion-error').style.display = 'none';
  }

  // Función para notificar éxito
  function mostrarNotificacion() {
    const exito = document.getElementById('notificacion-exito');
    exito.style.display = 'block';

    setTimeout(() => {
      exito.style.display = 'none';
    }, 5000);
  }

  // Validación del formulario antes de enviar
  formCarrito.addEventListener('submit', function (e) {
    if (cantidadActual === 0) {
      e.preventDefault();
      mostrarError('Por favor, seleccioná al menos una entrada.');
      return;
    }

    if (cantidadActual > maxStock) {
      e.preventDefault();
      mostrarError('La cantidad seleccionada excede el stock disponible.');
      return;
    }

    mostrarNotificacion();
  });
}







// ------------------------
// obras
const inputMembersOld = document.getElementById("members-old");

let membersOld = [];

if (inputMembersOld) {
  membersOld = JSON.parse(inputMembersOld.value);
}

if (inputMembersOld) {

  let indiceMember = 0;

  //Función para añadir miembros
  function crearInputMiembro(labelId, nombre = "", indice = null) {

    if (indice === null) {
      indice = indiceMember++;
    }

    const contenedor = document.getElementById(`label-${labelId}`);

    const grupo = document.createElement("div");
    grupo.classList.add("input-group", "mb-3");

    const inputNombre = document.createElement("input");
    inputNombre.type = "text";
    inputNombre.name = `members[${indice}][name]`;
    inputNombre.classList.add("form-control");
    inputNombre.value = nombre;

    const inputLabel = document.createElement("input");
    inputLabel.type = "hidden";
    inputLabel.name = `members[${indice}][label_id]`;
    inputLabel.value = labelId;

    const botonEliminar = document.createElement("button");
    botonEliminar.type = "button";
    botonEliminar.classList.add(
      "borrar",
      "btn",
      "btn-danger",
      "ms-2",
      "eliminar-miembro"
    );

    const icono = document.createElement("i");
    icono.classList.add("bi", "bi-trash");

    botonEliminar.appendChild(icono);

    grupo.appendChild(inputNombre);
    grupo.appendChild(inputLabel);
    grupo.appendChild(botonEliminar);

    contenedor.appendChild(grupo);
  }

  // Restaurar datos después de un old()
  if (Object.keys(membersOld).length > 0) {
    Object.entries(membersOld).forEach(([indice, member]) => {

      crearInputMiembro(
        member.label_id,
        member.name,
        indice
      );
      indiceMember = Math.max(indiceMember, Number(indice) + 1);
    });
  } else {
    // Crear un input vacío por cada label
    document.querySelectorAll(".agregar-miembro").forEach(boton => {
      crearInputMiembro(boton.dataset.label);
    });
  }

  // Agregar nuevos miembros
  document.querySelectorAll(".agregar-miembro").forEach(boton => {
    boton.addEventListener("click", function () {
      crearInputMiembro(this.dataset.label);
    });
  });

  // Eliminar
  document.addEventListener("click", function (e) {
    const boton = e.target.closest(".eliminar-miembro");

    if (!boton) return;

    boton.closest(".input-group").remove();
  });

}