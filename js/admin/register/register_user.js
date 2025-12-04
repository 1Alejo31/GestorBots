// Validación y envío del formulario de registro
document.addEventListener('DOMContentLoaded', function () {
    // Esperar un poco para asegurar que el DOM esté completamente cargado
    setTimeout(function () {
        initializeForm();
    }, 100);
});

// Función global para manejar el envío del formulario
function guardarUsuario() {

    const form = document.getElementById('formRegister');

    if (!form) {
        console.error('Formulario no encontrado');
        return;
    }

    // Validar formulario con Bootstrap
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        console.log('Formulario no válido');
        return;
    }

    // Capturar todos los datos del formulario
    const formData = {
        // Información Personal
        primer_nombre: document.getElementById('primer_nombre')?.value.trim() || '',
        segundo_nombre: document.getElementById('segundo_nombre')?.value.trim() || '',
        primer_apellido: document.getElementById('primer_apellido')?.value.trim() || '',
        segundo_apellido: document.getElementById('segundo_apellido')?.value.trim() || '',
        fecha_nacimiento: document.getElementById('fecha_nacimiento')?.value || '',
        tipo_documento: document.getElementById('tipo_documento')?.value || '',
        documento: document.getElementById('documento')?.value.trim() || '',
        celular: document.getElementById('telefono_movil')?.value.trim() || '',

        // Información de Cuenta
        email: document.getElementById('email')?.value.trim() || '',
        password: document.getElementById('password')?.value || '',
        tipo_usuario: document.getElementById('tipo_usuario')?.value || '',
        tipo_servicio: document.getElementById('tipo_servicio')?.value || '',

        // Información de Empresa
        nombre_empresa: document.getElementById('nombre_empresa')?.value.trim() || '',
        nit_empresa: document.getElementById('nit_empresa')?.value.trim() || '',
        direccion_empresa: document.getElementById('direccion_empresa')?.value.trim() || '',
        telefono_movil: document.getElementById('telefono_movil_e')?.value.trim() || '',
        url_pagina: document.getElementById('url_pagina')?.value.trim() || '',

        // Términos y condiciones
        terminos: document.getElementById('terminos')?.checked || false
    };

    // Enviar datos al servidor
    registerUser(formData);
}

function initializeForm() {
    const form = document.getElementById('formRegister');
    const documentoField = document.getElementById('documento');
    const passwordField = document.getElementById('password');

    if (!form || !documentoField || !passwordField) {
        console.log('Elementos del formulario no encontrados, reintentando...');
        setTimeout(initializeForm, 200);
        return;
    }

    // Auto-llenar contraseña con número de documento
    documentoField.addEventListener('input', function () {
        passwordField.value = this.value;
    });

    // Inicializar Flatpickr para fecha de nacimiento
    const flatpickrElement = document.querySelector('.flatpickr-validation');
    if (flatpickrElement && typeof flatpickr !== 'undefined') {
        flatpickr(flatpickrElement, {
            dateFormat: 'Y-m-d',
            maxDate: 'today',
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                    longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
                },
                months: {
                    shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
                }
            },
            monthSelectorType: 'static'
        });
    } else {
        console.error('Flatpickr no está disponible o elemento no encontrado');
    }

    // Validaciones en tiempo real
    setupValidations();
}

function setupValidations() {
    // Validación de email
    const emailField = document.getElementById('email');
    if (emailField) {
        emailField.addEventListener('blur', function () {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailRegex.test(this.value)) {
                this.setCustomValidity('Por favor ingrese un email válido');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Validación de teléfono
    const telefonoField = document.getElementById('telefono-movil');
    if (telefonoField) {
        telefonoField.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9\s\+\-]/g, '');
        });
    }

    // Validación de NIT
    const nitField = document.getElementById('nit_empresa');
    if (nitField) {
        nitField.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9\-]/g, '');
        });
    }

    // Validación de documento
    const documentoField = document.getElementById('documento');
    if (documentoField) {
        documentoField.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
}

// Función para registrar usuario
function registerUser(userData) {
    // Mostrar loading
    const submitBtn = document.querySelector('button[onclick="guardarUsuario()"]');
    let originalText = ''; // Definir fuera del bloque condicional
    
    // Si no se encuentra el botón, continuar sin modificar la UI
    if (!submitBtn) {
        console.warn('Botón de registro no encontrado');
    } else {
        originalText = submitBtn.innerHTML; // Asignar valor aquí
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Registrando...';
        submitBtn.disabled = true;
    }

    return new Promise(() => {
        const data = {
            primer_nombre: userData.primer_nombre,
            segundo_nombre: userData.segundo_nombre,
            primer_apellido: userData.primer_apellido,
            segundo_apellido: userData.segundo_apellido,
            fecha_nacimiento: userData.fecha_nacimiento,
            tipo_documento: userData.tipo_documento,
            documento: userData.documento,
            celular: userData.celular,
            email: userData.email,
            password: userData.password,
            tipo_usuario: userData.tipo_usuario,
            tipo_servicio: userData.tipo_servicio,
            nombre_empresa: userData.nombre_empresa,
            nit_empresa: userData.nit_empresa,
            direccion_empresa: userData.direccion_empresa,
            telefono_movil: userData.telefono_movil,
            url_pagina: userData.url_pagina,
            terminos: userData.terminos
        };

        const requestOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        };

        const url = '../controller/register/register_users_controller.php';

        fetch(url, requestOptions)
            .then(response => response.text())
            .then(text => {
                // Restaurar botón
                if (submitBtn) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }

                let jsonResponse;
                try {
                    jsonResponse = JSON.parse(text);
                } catch (e) {
                    console.error("No es un JSON válido:", e);
                    console.error("Respuesta del servidor:", text);
                    showAlert('error', 'Error: Respuesta del servidor no válida');
                    return;
                }

                if (jsonResponse.status === 0) {
                    console.log(`jsonResponse.status ${jsonResponse.status}`);
                    // Clear form
                    const form = document.getElementById('formRegister');
                    form.reset();
                    form.classList.remove('was-validated');
                    
                    // Reset any custom form elements (like flatpickr)
                    const flatpickrElement = form.querySelector('.flatpickr-validation');
                    if (flatpickrElement) {
                        flatpickrElement._flatpickr.clear();
                    }

                    // Clear any custom validations
                    Array.from(form.elements).forEach(element => {
                        element.setCustomValidity('');
                    });

                    // Show success messages
                    showAlert('success', jsonResponse.message);
                    document.getElementById('formRegister').reset();
                    document.getElementById('formRegister').classList.remove('was-validated');
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "¡Registro Exitoso!",
                        showConfirmButton: false,
                        timer: 1500
                    });

                } else {
                    // Error del servidor
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Oops...",
                        text: jsonResponse.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                    showAlert('error', jsonResponse.message);
                }
            })
            .catch(error => {
                // Restaurar botón
                if (submitBtn) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }

                console.error('Error:', error);
                showAlert('error', 'Error al registrar usuario: ' + error.message);
            });
    });
}

// Función para mostrar alertas
function showAlert(type, message) {
    // Crear elemento de alerta
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class="bx bx-${type === 'success' ? 'check-circle' : 'error-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    // Insertar al inicio del formulario
    const form = document.getElementById('formRegister');
    form.insertBefore(alertDiv, form.firstChild);

    // Auto-remover después de 5 segundos
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Configuración de Flatpickr en español
function initializeFlatpickr() {
    const fechaNacimiento = document.getElementById('fecha_nacimiento');
    if (fechaNacimiento) {
        flatpickr(fechaNacimiento, {
            dateFormat: "Y-m-d",
            maxDate: "today",
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                    longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
                },
                months: {
                    shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
                }
            }
        });
    }
}



(function () {
    // Inicializar Flatpickr para fecha de nacimiento
    const flatpickrDate = document.querySelector('.flatpickr-validation');
    if (flatpickrDate) {
        flatpickrDate.flatpickr({
            monthSelectorType: 'static',
            dateFormat: 'Y-m-d',
            maxDate: 'today',
            locale: 'es'
        });
    }

    // Auto-llenar contraseña con documento
    const documentoInput = document.getElementById('documento');
    const passwordInput = document.getElementById('password');

    documentoInput.addEventListener('input', function () {
        passwordInput.value = this.value;
    });

    const urlInput = document.getElementById('url-pagina');
    urlInput.addEventListener('blur', function () {
        if (this.value && !this.value.match(/^https?:\/\/.+/)) {
            this.setCustomValidity('La URL debe comenzar con http:// o https://');
        } else {
            this.setCustomValidity('');
        }
    });

    // Validación de teléfono
    const telefonoInput = document.getElementById('telefono-movil');
    telefonoInput.addEventListener('input', function () {
        // Permitir solo números, espacios, + y -
        this.value = this.value.replace(/[^0-9\s\+\-]/g, '');
    });

    // Validación de NIT
    const nitInput = document.getElementById('nit-empresa');
    nitInput.addEventListener('input', function () {
        // Permitir solo números y guiones
        this.value = this.value.replace(/[^0-9\-]/g, '');
    });

})();