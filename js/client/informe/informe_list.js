// Variables globales
let informesTable;
let informesData = [];

// Inicializar cuando el documento esté listo
$(document).ready(function() {
    // Verificar que DataTables esté disponible
    if (typeof $.fn.DataTable === 'undefined') {
        console.error('DataTables no está disponible. Reintentando en 1 segundo...');
        setTimeout(function() {
            if (typeof $.fn.DataTable !== 'undefined') {
                initializeComponents();
            } else {
                console.error('DataTables sigue sin estar disponible después del reintento.');
                alert('Error: Las librerías necesarias no están cargadas. Por favor, recarga la página.');
            }
        }, 1000);
    } else {
        initializeComponents();
    }
});

// Función para inicializar todos los componentes
function initializeComponents() {
    initializeDataTable();
    loadInformes();
    setupEventListeners();
}

// Inicializar DataTable
function initializeDataTable() {
    try {
        // Verificar que el elemento existe
        if ($('#informesTable').length === 0) {
            console.error('Elemento #informesTable no encontrado');
            return;
        }

        // Destruir DataTable existente si existe
        if ($.fn.DataTable.isDataTable('#informesTable')) {
            $('#informesTable').DataTable().destroy();
        }

        informesTable = $('#informesTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        responsive: true,
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '📊 Excel',
                className: 'btn btn-success btn-sm',
                title: 'Informes_Mensajes_Procesados',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'csvHtml5',
                text: '📄 CSV',
                className: 'btn btn-info btn-sm',
                title: 'Informes_Mensajes_Procesados',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                text: '📑 PDF',
                className: 'btn btn-danger btn-sm',
                title: 'Informes de Mensajes Procesados',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                customize: function(doc) {
                    doc.content[1].table.widths = ['20%', '40%', '20%', '20%'];
                    doc.styles.tableHeader.fontSize = 10;
                    doc.defaultStyle.fontSize = 8;
                }
            }
        ],
        columns: [
            { 
                data: 'nombre_empresa',
                title: '🏢 Empresa'
            },
            { 
                data: 'fecha_procesamiento',
                title: '📅 Fecha Procesamiento'
            },
            { 
                data: 'estado',
                title: '📋 Estado',
                render: function(data, type, row) {
                    let badgeClass = 'bg-secondary';
                    switch(data) {
                        case 'SIN GESTION':
                            badgeClass = 'bg-success';
                            break;
                        case 'GESTIONADO':
                            badgeClass = 'bg-info';
                            break;
                        case 'ENVIADO':
                            badgeClass = 'bg-primary';
                            break;
                    }
                    return `<span class="badge ${badgeClass}">${data}</span>`;
                }
            },
            {
                data: null,
                title: '🔧 Acciones',
                orderable: false,
                render: function(data, type, row, meta) {
                    return `
                        <button class="btn btn-sm btn-outline-primary" onclick="verDetalle(${meta.row})">
                            👁️ Ver
                        </button>
                    `;
                }
            }
        ]
    });
    
    console.log('DataTable inicializado correctamente');
    
    } catch (error) {
        console.error('Error al inicializar DataTable:', error);
        alert('Error al inicializar la tabla de datos: ' + error.message);
    }
}

// Cargar informes desde el servidor
function loadInformes() {
    showLoading(true);
    
    fetch('../controller/informe/informeController.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        showLoading(false);
        
        if (data.status === 'success') {
            informesData = data.data;
            updateDataTable(informesData);
            
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: `Se cargaron ${informesData.length} registros`,
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Sin datos',
                text: data.message || 'No se encontraron informes',
                confirmButtonText: 'Aceptar'
            });
            updateDataTable([]);
        }
    })
    .catch(error => {
        showLoading(false);
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al cargar los informes: ' + error.message,
            confirmButtonText: 'Aceptar'
        });
    });
}

// Actualizar DataTable con nuevos datos
function updateDataTable(data) {
    informesTable.clear();
    informesTable.rows.add(data);
    informesTable.draw();
}

// Mostrar/ocultar loading
function showLoading(show) {
    if (show) {
        $('#loadingSpinner').removeClass('d-none');
        $('#informesTable').addClass('d-none');
    } else {
        $('#loadingSpinner').addClass('d-none');
        $('#informesTable').removeClass('d-none');
    }
}

// Ver detalle de un registro
function verDetalle(rowIndex) {
    const registro = informesData[rowIndex];
    
    const detalleHtml = `
        <div class="row">
            <div class="col-md-12">
                <h6><strong>🏢 Empresa:</strong></h6>
                <p>${registro.nombre_empresa}</p>
                
                <h6><strong>📅 Fecha de Procesamiento:</strong></h6>
                <p>${registro.fecha_procesamiento}</p>
                
                <h6><strong>📋 Estado:</strong></h6>
                <p><span class="badge bg-info">${registro.estado}</span></p>
            </div>
        </div>
    `;
    
    $('#detalleContent').html(detalleHtml);
    $('#detalleModal').modal('show');
}

// Configurar event listeners
function setupEventListeners() {
    // Filtros
    $('#filtroEmpresa').on('keyup', function() {
        informesTable.column(0).search(this.value).draw();
    });
    
    $('#filtroEstado').on('change', function() {
        informesTable.column(3).search(this.value).draw();
    });
    
    $('#filtroFecha').on('change', function() {
        const fecha = this.value;
        if (fecha) {
            informesTable.column(2).search(fecha).draw();
        } else {
            informesTable.column(2).search('').draw();
        }
    });
    
    // Botones de exportación personalizados
    $('#exportExcel').on('click', function() {
        informesTable.button('.buttons-excel').trigger();
    });
    
    $('#exportCSV').on('click', function() {
        informesTable.button('.buttons-csv').trigger();
    });
    
    $('#exportPDF').on('click', function() {
        informesTable.button('.buttons-pdf').trigger();
    });
}