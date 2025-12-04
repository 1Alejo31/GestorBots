// Variables globales
let currentFileData = null;
let isPublicidadFile = false;

// Función para cargar XLSX dinámicamente
function loadXLSX() {
    return new Promise((resolve, reject) => {
        // Lista de CDNs para intentar
        const cdnUrls = [
            'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js',
            'https://unpkg.com/xlsx@0.18.5/dist/xlsx.full.min.js',
            'https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js'
        ];

        let currentIndex = 0;

        function tryLoadScript() {
            if (currentIndex >= cdnUrls.length) {
                reject(new Error('No se pudo cargar la librería XLSX desde ningún CDN'));
                return;
            }

            const script = document.createElement('script');
            script.src = cdnUrls[currentIndex];

            script.onload = function() {
                resolve();
            };

            script.onerror = function() {
                console.warn('Falló cargar XLSX desde:', cdnUrls[currentIndex]);
                currentIndex++;
                tryLoadScript();
            };

            document.head.appendChild(script);
        }

        tryLoadScript();
    });
}

// Cargar XLSX y luego inicializar la aplicación
loadXLSX().then(() => {
    initializeExcelUploader();
}).catch(error => {
    console.error('Error cargando XLSX:', error);
    alert('Error: No se pudo cargar la librería para leer archivos Excel. Verifica tu conexión a internet.');
});

function initializeExcelUploader() {
    const excelFileInput = document.getElementById('excelFile');
    const loadPreviewBtn = document.getElementById('loadPreviewBtn');
    const previewArea = document.getElementById('previewArea');
    const previewTable = document.getElementById('previewTable');
    const previewTableHead = document.getElementById('previewTableHead');
    const previewTableBody = document.getElementById('previewTableBody');
    const saveToDbBtn = document.getElementById('saveToDbBtn');
    const loadAnotherBtn = document.getElementById('loadAnotherBtn');

    // Remover estas líneas ya que ahora son globales:
    // let currentFileData = null;
    // let isPublicidadFile = false;

    // Verificar que todos los elementos existan
    if (!excelFileInput || !loadPreviewBtn || !previewArea) {
        console.error('No se encontraron todos los elementos del DOM');
        return;
    }

    // Habilitar botón de vista previa cuando se selecciona un archivo
    excelFileInput.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            // Verificar si es exactamente el archivo NOTIFICACION.xlsx o BASE_DE_DATOS_BOOT_AGENDAMIENTO_AUTOMATICO
            const fileName = file.name;
            isPublicidadFile = (fileName === 'NOTIFICACION.xlsx');

            if (isPublicidadFile) {
                // Archivo correcto: habilitar botón de vista previa
                loadPreviewBtn.disabled = false;
                loadPreviewBtn.style.opacity = '1';
                loadPreviewBtn.style.pointerEvents = 'auto';
            } else {
                // Archivo incorrecto: deshabilitar botón y mostrar mensaje
                loadPreviewBtn.disabled = true;
                loadPreviewBtn.style.opacity = '0.5';
                loadPreviewBtn.style.pointerEvents = 'none';

                // Ocultar área de vista previa si estaba visible
                previewArea.classList.add('d-none');

                // Mostrar mensaje de error
                Swal.fire({
                    icon: 'warning',
                    title: 'Archivo Incorrecto',
                    text: 'El archivo debe llamarse exactamente "NOTIFICACION.xlsx" Archivo actual: "' + fileName + '"',
                    timer: 6500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    customClass: {
                        container: 'swal-high-zindex'
                    },
                    zIndex: 10000
                });
                console.warn('Archivo no válido. Se requiere: NOTIFICACION.xlsx, actual:', fileName);
            }

            previewArea.classList.add('d-none');
        } else {
            loadPreviewBtn.disabled = true;
            isPublicidadFile = false;
        }
    });

    // Cargar vista previa
    loadPreviewBtn.addEventListener('click', function(e) {
        e.preventDefault();

        const file = excelFileInput.files[0];
        if (!file) {
            console.error('No hay archivo seleccionado');
            Swal.fire({
                icon: 'warning',
                title: 'Sin Archivo',
                text: 'Por favor selecciona un archivo primero',
                confirmButtonText: 'Entendido',
                customClass: {
                    container: 'swal-high-zindex'
                },
                zIndex: 10000
            });
            return;
        }

        // Verificar nuevamente el nombre del archivo
        if (file.name !== 'NOTIFICACION.xlsx') {
            Swal.fire({
                icon: 'error',
                title: 'Archivo Incorrecto',
                text: 'El archivo debe llamarse exactamente "NOTIFICACION.xlsx"',
                confirmButtonText: 'Entendido',
                customClass: {
                    container: 'swal-high-zindex'
                },
                zIndex: 10000
            });
            return;
        }

        const spinner = this.querySelector('.spinner-border');
        if (spinner) {
            spinner.classList.remove('d-none');
        }
        this.disabled = true;

        const reader = new FileReader();

        reader.onload = function(e) {
            try {
                const data = new Uint8Array(e.target.result);

                const workbook = XLSX.read(data, {
                    type: 'array'
                });

                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];

                // Convertir a JSON
                let jsonData = XLSX.utils.sheet_to_json(worksheet, {
                    header: 1
                });

                // Como ya validamos que es NOTIFICACION.xlsx, mostrar solo columnas A-G
                jsonData = jsonData.map(row => row.slice(0, 15));

                currentFileData = jsonData;
                displayPreview(jsonData);

            } catch (error) {
                console.error('Error al procesar el archivo:', error);
                alert('Error al leer el archivo: ' + error.message);
            } finally {
                if (spinner) {
                    spinner.classList.add('d-none');
                }
                loadPreviewBtn.disabled = false;
            }
        };

        reader.onerror = function(error) {
            console.error('Error al leer el archivo:', error);
            alert('Error al leer el archivo');
            if (spinner) {
                spinner.classList.add('d-none');
            }
            loadPreviewBtn.disabled = false;
        };

        reader.readAsArrayBuffer(file);
    });

    // Función para mostrar la vista previa
    function displayPreview(data) {
        if (data.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Archivo Vacío',
                text: 'El archivo está vacío',
                confirmButtonText: 'Entendido',
                customClass: {
                    container: 'swal-high-zindex'
                },
                zIndex: 10000
            });
            return;
        }

        // Limpiar tabla
        previewTableHead.innerHTML = '';
        previewTableBody.innerHTML = '';

        // Crear encabezados
        if (data.length > 0) {
            const headerRow = document.createElement('tr');
            const maxCols = Math.max(...data.map(row => row.length));

            for (let i = 0; i < maxCols; i++) {
                const th = document.createElement('th');
                th.textContent = data[0][i] || `Columna ${i + 1}`;
                headerRow.appendChild(th);
            }
            previewTableHead.appendChild(headerRow);

            // Crear filas de datos (mostrar máximo 10 filas para vista previa)
            const maxRows = Math.min(data.length, 11);

            for (let i = 1; i < maxRows; i++) {
                const row = document.createElement('tr');
                for (let j = 0; j < maxCols; j++) {
                    const td = document.createElement('td');
                    td.textContent = data[i][j] || '';
                    row.appendChild(td);
                }
                previewTableBody.appendChild(row);
            }
        }

        previewArea.classList.remove('d-none');

        // Controlar visibilidad del botón de guardar según el archivo
        const saveToDbBtn = document.getElementById('saveToDbBtn');
        if (isPublicidadFile) {
            // Mostrar botón de guardar solo para archivos NOTIFICACION.xlsx
            saveToDbBtn.style.display = 'inline-block';

            // Mostrar información adicional
            const existingAlert = previewArea.querySelector('.alert-info');
            if (existingAlert) {
                existingAlert.remove();
            }

            const info = document.createElement('div');
            info.className = 'alert alert-success mt-2';
            info.innerHTML = '<strong>Archivo NOTIFICACION.xlsx detectado:</strong> Mostrando columnas A-G.';
            previewArea.insertBefore(info, previewArea.firstChild);
        } else {
            // Ocultar botón de guardar para otros archivos
            saveToDbBtn.style.display = 'none';
        }
    }

    // Guardar en base de datos
    saveToDbBtn.addEventListener('click', function() {
        saveToDatabase();
    });

    // Cargar otro archivo
    loadAnotherBtn.addEventListener('click', function() {
        resetForm();
    });

    // Función para resetear el formulario
    function resetForm() {
        excelFileInput.value = '';
        loadPreviewBtn.disabled = true;
        previewArea.classList.add('d-none');

        // Restaurar visibilidad del botón de guardar
        const saveToDbBtn = document.getElementById('saveToDbBtn');
        if (saveToDbBtn) {
            saveToDbBtn.style.display = 'inline-block';
        }

        const alerts = previewArea.querySelectorAll('.alert-info, .alert-success');
        alerts.forEach(alert => alert.remove());
    }

    // Forzar un evento change si ya hay un archivo seleccionado
    if (excelFileInput.files.length > 0) {
        excelFileInput.dispatchEvent(new Event('change'));
    }
}

// Función para guardar datos en la base de datos
function saveToDatabase() {
    if (!currentFileData || currentFileData.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Sin datos',
            text: 'No hay datos para guardar en la base de datos.'
        });
        return;
    }

    // Mostrar confirmación antes de guardar
    Swal.fire({
        title: '¿Confirmar guardado?',
        text: `Se guardarán ${currentFileData.length - 1} registros en la base de datos.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            performSave();
        }
    });
}

// Función que realiza el guardado
function performSave() {
    const saveButton = document.getElementById('saveToDbBtn');
    
    // Deshabilitar el botón y mostrar loading
    if (saveButton) {
        saveButton.disabled = true;
        saveButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Guardando...';
    }

    // Mostrar spinner de carga con SweetAlert2
    Swal.fire({
        title: 'Guardando datos...',
        text: 'Por favor espere mientras se procesan los datos.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Enviar datos al servidor
    fetch('../controller/excel/excel_controller.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            data: currentFileData
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        Swal.close();
        
        // Rehabilitar el botón
        if (saveButton) {
            saveButton.disabled = false;
            saveButton.innerHTML = 'Guardar en Base de Datos';
        }
        
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: data.message || 'Los datos se han guardado correctamente.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Limpiar el formulario y ocultar la tabla
                resetForm();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error al guardar',
                text: data.message || 'Ocurrió un error al guardar los datos.',
                confirmButtonText: 'Aceptar'
            });
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Error:', error);
        
        // Rehabilitar el botón en caso de error
        if (saveButton) {
            saveButton.disabled = false;
            saveButton.innerHTML = 'Guardar en Base de Datos';
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo conectar con el servidor. Por favor, inténtelo de nuevo.',
            confirmButtonText: 'Aceptar'
        });
    });
}

// Función para resetear el formulario
function resetForm() {
    const fileInput = document.getElementById('excelFile');
    const previewContainer = document.getElementById('previewContainer');
    const saveButton = document.getElementById('saveToDbBtn');
    
    if (fileInput) fileInput.value = '';
    if (previewContainer) previewContainer.style.display = 'none';
    if (saveButton) saveButton.style.display = 'none';
    
    currentFileData = null;
}