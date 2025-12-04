// Función global que se ejecuta cuando se hace click en el botón
function btnConfirmar() {

    // Cambiar la imagen de fondo con efecto de degradado
    const whatsappCard = document.getElementById('whatsappCard');
    if (whatsappCard) {
        // Remover completamente el atributo style para eliminar el CSS inline
        whatsappCard.removeAttribute('style');

        // Aplicar todos los estilos nuevamente incluyendo la nueva imagen
        whatsappCard.style.cssText = `
            position: relative;
            background-image: url('../assets/gestion.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 500px;
            transition: background-image 1s ease-in-out;
        `;

        console.log('Imagen cambiada a gestion.jpg');

        // Opcional: También cambiar el título para reflejar el cambio
        const tituloWhatsapp = document.getElementById('tituloWhatsapp');
        if (tituloWhatsapp) {
            setTimeout(() => {
                tituloWhatsapp.textContent = 'Gestión de WhatsApp';
            }, 500); // Cambiar el título a la mitad de la transición
        }
    }
    document.querySelector('#estadisticas').hidden = false;

    aplicarEstadoIniciado();

}

function consultarEstadoSesion() {
    fetch('../controller/session_estatus/sessionStatusController.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json())
        .then(data => {
            console.log('Estado de sesión:', data);

            if (data.status === 0) {
                const estadoSesion = data.data.estado_sesion;

                if (estadoSesion === 'INICIADO') {
                    // Aplicar automáticamente los cambios sin hacer click
                    aplicarEstadoIniciado();
                } else if (estadoSesion === 'SIN INICIAR') {
                    // Mostrar formulario normal (estado actual)
                    //console.log('Bot sin iniciar - mostrando formulario normal');
                }
            } else {
                console.error('Error al consultar estado:', data.message);
            }
        })
        .catch(error => {
            console.error('Error en la consulta:', error);
        });
}

function aplicarEstadoIniciado() {

    const whatsappCard = document.getElementById('whatsappCard');
    if (whatsappCard) {
        whatsappCard.style.backgroundImage = "url('../assets/gestion.jpg')";
        whatsappCard.style.transition = 'background-image 1s ease-in-out';
    }

    // AGREGAR: Mostrar la sección de estadísticas
    const estadisticas = document.getElementById('estadisticas');
    if (estadisticas) {
        estadisticas.hidden = false;
    }

    const tituloWhatsapp = document.getElementById('tituloWhatsapp');
    const tituloContainer = tituloWhatsapp ? tituloWhatsapp.parentElement : null;
    const formularioInicio = document.getElementById('formularioInicio');
    const codigoDeInicio = document.getElementById('codigoDeInicio');

    // Cambiar el título inmediatamente
    if (tituloWhatsapp) {
        tituloWhatsapp.textContent = 'Logueado, el bot está procesando la información, por favor no cerrar la sesión en el celular';
    }

    // Cambiar el estilo del contenedor del título
    if (tituloContainer) {
        tituloContainer.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
        tituloContainer.style.transition = 'background-color 0.5s ease-in-out';
        tituloContainer.style.padding = '20px';
        tituloContainer.style.borderRadius = '10px';
    }

    // Ocultar los formularios inmediatamente
    if (formularioInicio) {
        formularioInicio.style.display = 'none';
    }

    if (codigoDeInicio) {
        codigoDeInicio.style.display = 'none';
    }

    // Mostrar mensaje de procesamiento inmediatamente
    setTimeout(function () {
        const card = document.getElementById('whatsappCard');
        if (card) {
            const processingMessage = document.createElement('div');
            processingMessage.className = 'text-center';
            processingMessage.style.position = 'absolute';
            processingMessage.style.top = '50%';
            processingMessage.style.left = '50%';
            processingMessage.style.transform = 'translate(-50%, -50%)';
            processingMessage.style.zIndex = '10';
            processingMessage.style.color = '#ffffff';
            processingMessage.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
            processingMessage.style.padding = '20px';
            processingMessage.style.borderRadius = '10px';
            processingMessage.style.opacity = '1';

            processingMessage.innerHTML = `
                <div class="spinner-border text-light mb-3" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p>El bot se encuentra procesando los datos, por favor no cerrar la sesión en el celular</p>
            `;

            card.appendChild(processingMessage);
        }
    }, 500);
}

// Función de inicialización que se llama cuando se carga el contenido dinámicamente
function inicializarGestorMessage() {

    consultarEstadoSesion();

}

// Función para validar el número de teléfono
function validarNumeroTelefono() {
    const numeroInput = document.getElementById('number');
    if (numeroInput) {
        const numero = numeroInput.value;

        // Verificar que solo contenga números y tenga máximo 10 dígitos
        if (!/^[0-9]{1,10}$/.test(numero)) {
            console.log('Número de teléfono inválido');
            return false;
        }

        console.log('Número de teléfono válido:', numero);
        return true;
    }
    return false;
}

function gestionarNumero() {
    if (!validarNumeroTelefono()) {
        Swal.fire({
            title: "Error de validación",
            text: "Por favor ingrese un número de teléfono válido (solo números, máximo 10 dígitos)",
            icon: "error"
        });
        return;
    }
    gestionarNumeroGet();
}


// Función para gestionar el número de teléfono
function gestionarNumeroGet() {
    const numeroInput = document.getElementById('number');
    const phoneNumber = numeroInput.value.trim();

    // Validar que el campo no esté vacío
    if (!phoneNumber) {
        Swal.fire({
            icon: 'warning',
            title: 'Campo requerido',
            text: 'Por favor ingrese un número de teléfono'
        });
        return;
    }

    // Validar formato (solo números, máximo 10 dígitos)
    if (!/^[0-9]{1,10}$/.test(phoneNumber)) {
        Swal.fire({
            icon: 'error',
            title: 'Formato inválido',
            text: 'El número debe contener solo dígitos y máximo 10 caracteres'
        });
        return;
    }

    // Mostrar loading
    Swal.fire({
        title: 'Actualizando...',
        text: 'Por favor espere mientras se actualiza el número',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('../controller/phoneUpdateController/phoneUpdateController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            phoneNumber: phoneNumber
        })
    })
        .then(response => response.json())
        .then(data => {
            Swal.close();

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.message
                }).then(() => {
                    // Ocultar formulario de inicio y mostrar código de inicio
                    const formularioInicio = document.getElementById('formularioInicio');
                    const codigoDeInicio = document.getElementById('codigoDeInicio');

                    if (formularioInicio) {
                        formularioInicio.hidden = true;
                    }
                    if (codigoDeInicio) {
                        codigoDeInicio.hidden = false;
                    }
                    iniciarVerificacionCodigos();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.close();
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor'
            });
        });
}


function verificarCodigosAutomaticamente() {
    // Verificar que todos los campos estén vacíos
    const campos = ['code1', 'code2', 'code3', 'code4', 'code6', 'code7', 'code8'];
    const todosVacios = campos.every(id => {
        const campo = document.getElementById(id);
        return campo && campo.value.trim() === '';
    });

    // Solo hacer la consulta si todos los campos están vacíos
    if (!todosVacios) {
        return;
    }

    fetch('../controller/verificationCodeController/verificationCodeController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.codes) {
                // Llenar los campos con los códigos obtenidos
                const campos = ['code1', 'code2', 'code3', 'code4', 'code6', 'code7', 'code8', 'code9'];
                campos.forEach((id, index) => {
                    const campo = document.getElementById(id);
                    if (campo && data.codes[id]) {
                        campo.value = data.codes[id];
                    }
                });
                document.querySelector('#confirmacion').hidden = false;
            }
        })
        .catch(error => {
            console.error('Error al verificar códigos:', error);
        });
}

// Iniciar el intervalo de verificación cada 3 segundos
let intervaloCodigos = null;

function iniciarVerificacionCodigos() {
    // Verificar si los campos ya están llenos antes de iniciar
    if (verificarCamposCompletos()) {
        console.log('Los campos ya están completos, no se inicia verificación automática');
        return;
    }

    if (intervaloCodigos) {
        clearInterval(intervaloCodigos);
    }
    intervaloCodigos = setInterval(verificarCodigosAutomaticamente, 3000);
    console.log('Verificación automática de códigos iniciada cada 3 segundos');
}

function detenerVerificacionCodigos() {
    if (intervaloCodigos) {
        clearInterval(intervaloCodigos);
        intervaloCodigos = null;
    }
}

// Función para verificar si todos los campos de código están completos
function verificarCamposCompletos() {
    const campos = ['code1', 'code2', 'code3', 'code4', 'code6', 'code7', 'code8'];

    for (let campo of campos) {
        const elemento = document.getElementById(campo);
        if (!elemento || elemento.value.trim() === '') {
            return false;
        }
    }
    return true;
}

document.addEventListener('DOMContentLoaded', function () {
    inicializarGestorMessage();
});
