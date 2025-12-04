// Función global para generar vista previa del mensaje
function generateMessagePreview() {
    const formData = new FormData(document.getElementById('cenlabForm'));

    // Obtener valores del formulario
    const nombre = formData.get('nombre') || '[Nombre]';
    const tipo = formData.get('tipo') || '[Tipo de examen]';
    const examen = formData.get('examenes') || '[Examen específico]';
    const empresa = formData.get('empresa') || '[Empresa]';
    const fechaAtencion = formData.get('fecha') || '[Fecha]';
    const lugar = formData.get('lugar') || '[Lugar]';
    const ciudad = formData.get('ciudad') || '[Ciudad]';
    const recomendaciones = formData.get('recomendaciones') || '';

    // Formatear fecha
    let fechaAtencion_formateada = fechaAtencion;
    if (fechaAtencion && fechaAtencion !== '[Fecha]') {
        const fecha = new Date(fechaAtencion);
        fechaAtencion_formateada = fecha.toLocaleDateString('es-ES', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    // Generar sección de recomendaciones si existe
    let seccion_recomendaciones = '';
    if (recomendaciones && recomendaciones.trim() !== '') {
        seccion_recomendaciones = `📋 *Recomendaciones importantes:*
${recomendaciones}
`;
    }

    // Generar mensaje completo
    const mensaje = `🏥 *CENTRO MÉDICO CENLAB* 
                 
                 👋 Hola ${nombre}, Soy Vicky!!! Su asistente virtual del Centro Médico CENLAB 
                 
                 
                 🤖 Le escribo para recordarle su examen de ${tipo}. 
                 Estamos muy contentos de poder atenderle en nuestro centro médico. 
                 
                 Somos los encargados de realizar los exámenes. 
 
                 🔬 *Exámenes a realizar:* 
                 • ${examen} 
                 
                 🎯 Le hemos programado una cita para la realización del exámen, requerido por la empresa ${empresa} 
                 
                 ${seccion_recomendaciones} 
                 
                 📅 *Detalles de la cita:* 
                 • Fecha: ${fechaAtencion_formateada} 
                 • Lugar: ${lugar} - ${ciudad} 
                 • Teléfono de contacto: 3112780473 
 
                 
                 ⏰ Agradecemos su puntualidad. Si tiene alguna inquietud, comuníquese con nosotros al número 3112780473 o al correo Info@cenlab.co`;

    // Mostrar en modal
    const modalBody = document.getElementById('messagePreview');
    if (modalBody) {
        modalBody.innerHTML = mensaje;
    }

    // Mostrar modal
    const modal = document.getElementById('previewModal');
    if (modal) {
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        } else {
            // Fallback manual si Bootstrap no está disponible
            modal.style.display = 'block';
            modal.classList.add('show');
            document.body.classList.add('modal-open');

            // Crear backdrop si no existe
            if (!document.querySelector('.modal-backdrop')) {
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
            }
        }
    }
}

// Función para mostrar alertas dinámicas
function showAlert(type, message) {
    // Remover alertas existentes
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());

    // Crear nueva alerta
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    // Insertar alerta al inicio del formulario
    const form = document.getElementById('cenlabForm');
    if (form) {
        form.insertBefore(alertDiv, form.firstChild);
    }

    // Auto-remover después de 5 segundos
    setTimeout(() => {
        if (alertDiv && alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Función para enviar datos al controlador
function saveCenlabData(formData) {
    return new Promise((resolve, reject) => {
        fetch('../controller/cenlab/cenlabController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.status === '0') {
                    resolve(data);
                } else {
                    reject(new Error(data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                reject(error);
            });
    });
}

// Función global para enviar formulario
function submitCenlabForm() {
    const form = document.getElementById('cenlabForm');
    if (!form) return;

    // Validar campos requeridos
    const requiredFields = ['nombre', 'correo', 'telefono', 'documento', 'tipo', 'examenes', 'empresa', 'fecha', 'lugar', 'ciudad', 'recomendaciones'];
    let isValid = true;
    let firstInvalidField = null;

    requiredFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field && !field.value.trim()) {
            field.classList.add('is-invalid');
            if (!firstInvalidField) {
                firstInvalidField = field;
            }
            isValid = false;
        } else if (field) {
            field.classList.remove('is-invalid');
        }
    });

    // Validaciones específicas para correos
    const emailFields = ['correo', 'correo_copia', 'correo_copia_s', 'correo_copia_t'];
    emailFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field && field.value && !isValidEmail(field.value)) {
            field.classList.add('is-invalid');
            isValid = false;
            if (!firstInvalidField) firstInvalidField = field;
        }
    });

    const phoneField = form.querySelector('[name="telefono"]');
    if (phoneField && phoneField.value && !isValidPhone(phoneField.value)) {
        phoneField.classList.add('is-invalid');
        isValid = false;
        if (!firstInvalidField) firstInvalidField = phoneField;
    }

    const docField = form.querySelector('[name="documento"]');
    if (docField && docField.value && !isValidDocument(docField.value)) {
        docField.classList.add('is-invalid');
        isValid = false;
        if (!firstInvalidField) firstInvalidField = docField;
    }

    if (!isValid) {
        showAlert('error', 'Por favor, complete todos los campos requeridos correctamente.');
        if (firstInvalidField) {
            firstInvalidField.focus();
        }
        return;
    }

    // Obtener datos del formulario
    const formData = new FormData(form);
    const data = {};

    // Convertir FormData a objeto
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }

    // Mostrar spinner en el botón
    const submitBtn = document.querySelector('button[onclick="submitCenlabForm()"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Guardando...';
    submitBtn.disabled = true;

    // Enviar datos al controlador
    saveCenlabData(data)
        .then(response => {
            // Restaurar botón
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;

            // Limpiar formulario
            form.reset();

            // Mostrar mensaje de éxito
            showAlert('success', 'Información guardada exitosamente');

            // Mostrar SweetAlert de éxito
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'La información del formulario CENLAB ha sido guardada correctamente.',
                    confirmButtonText: 'Aceptar'
                });
            }
        })
        .catch(error => {
            // Restaurar botón
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;

            console.error('Error al guardar:', error);

            // Mostrar mensaje de error
            showAlert('error', 'Error: ' + error.message);

            // Mostrar SweetAlert de error
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al guardar la información: ' + error.message,
                    confirmButtonText: 'Aceptar'
                });
            }
        });
}

// Función para validar el número de teléfono
function validarNumeroTelefono(numero) {
    // Verificar que solo contenga números y tenga máximo 10 dígitos
    if (!/^[0-9]{1,10}$/.test(numero)) {
        console.log('Número de teléfono inválido');
        return false;
    }

    console.log('Número de teléfono válido:', numero);
    return true;
}

// Función global para validar campo individual
function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;

    // Remover clase de error primero
    field.classList.remove('is-invalid');

    // Validar según el tipo de campo
    switch (fieldName) {
        case 'email':
            if (value && !isValidEmail(value)) {
                field.classList.add('is-invalid');
            }
            break;
        case 'telefono':
            if (value && !isValidPhone(value)) {
                field.classList.add('is-invalid');
            }
            break;
        case 'documento':
            if (value && !isValidDocument(value)) {
                field.classList.add('is-invalid');
            }
            break;
        default:
            // Para campos requeridos básicos
            if (!value) {
                field.classList.add('is-invalid');
            }
            break;
    }
}

// Función global para validar email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Función global para validar teléfono
function isValidPhone(phone) {
    const phoneRegex = /^[0-9]{10}$/;
    return phoneRegex.test(phone.replace(/\s/g, ''));
}

// Función global para validar documento
function isValidDocument(document) {
    const docRegex = /^[0-9]{6,12}$/;
    return docRegex.test(document);
}

// Función de inicialización que se llama cuando se carga el contenido dinámicamente
function inicializarCenlabForm() {
    console.log('Inicializando formulario CENLAB...');

    // Inicializar formateo de campos
    const phoneField = document.querySelector('[name="telefono"]');
    if (phoneField) {
        phoneField.addEventListener('input', function (e) {
            // Permitir solo números
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            // Limitar a 10 dígitos
            if (e.target.value.length > 10) {
                e.target.value = e.target.value.slice(0, 10);
            }
        });
    }

    const docField = document.querySelector('[name="documento"]');
    if (docField) {
        docField.addEventListener('input', function (e) {
            // Permitir solo números
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            // Limitar a 12 dígitos
            if (e.target.value.length > 12) {
                e.target.value = e.target.value.slice(0, 12);
            }
        });
    }

    // Agregar validación en tiempo real a todos los campos
    const form = document.getElementById('cenlabForm');
    if (form) {
        const fields = form.querySelectorAll('input, select, textarea');
        fields.forEach(field => {
            field.addEventListener('blur', function () {
                validateField(this);
            });
        });
    }
}

// Event listeners que se ejecutan cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function () {
    inicializarCenlabForm();
});