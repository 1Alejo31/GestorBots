<?php
session_start();

if ($_SESSION['K_US']) {
    if ($_SESSION['T_US'] === 'admin' && $_SESSION['T_CL'] === "Personalizado") {
?>

        <!-- Incluir SweetAlert2 -->
        <!-- SweetAlert2 desde CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        <div class="row">
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <img class="card-img-top" src="../assets/register.webp" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Registro Usuarios</h5>
                        <p class="card-text">
                            Modulo para el registro de usuarios
                        </p>
                        <a onclick="cargar_contenido('contenido_principal', 'admin/register/register.php')" class="btn btn-outline-primary float-end">Ingresar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <img class="card-img-top" src="../assets/inform.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Informes</h5>
                        <p class="card-text">
                            Modulo administrador para informes
                        </p>
                        <a href="javascript:void(0)" class="btn btn-outline-primary float-end">Ingresar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <img class="card-img-top" src="../assets/bots.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Bots</h5>
                        <p class="card-text">
                            Modulo administrador de bots
                        </p>
                        <a href="javascript:void(0)" class="btn btn-outline-primary float-end">Ingresar</a>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else if ($_SESSION['T_US'] === 'cliente' && $_SESSION['T_CL'] === "Personalizado") { ?>

        <div class="row">
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <img class="card-img-top" src="../assets/gestor2.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Gestor mensajeria</h5>
                        <p class="card-text">
                            Gestionar Bot de envio de mensajes
                        </p>
                        <a onclick="cargar_contenido('contenido_principal', 'client/gestor_message/gestor_message.php')" class="btn btn-outline-primary float-end">Ingresar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <img class="card-img-top" src="../assets/upload.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Cargar base de datos</h5>
                        <p class="card-text">
                            Modulo para cargar excel
                        </p>
                        <a href="javascript:void(0)" class="btn btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#excelUploadModal">Ingresar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <img class="card-img-top" src="../assets/informe.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Tipificador</h5>
                        <p class="card-text">
                            Tipificador uno a uno
                        </p>
                        <a onclick="cargar_contenido('contenido_principal', 'client/cenlab/cenlab_form.php')" class="btn btn-outline-primary float-end">Ingresar</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } else {
    ?>

        <div class="row">
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <img class="card-img-top" src="../assets/gestor2.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Gestor mensajeria</h5>
                        <p class="card-text">
                            Gestionar Bot de envio de mensajes
                        </p>
                        <a onclick="cargar_contenido('contenido_principal', 'client/gestor_message/gestor_message.php')" class="btn btn-outline-primary float-end">Ingresar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <img class="card-img-top" src="../assets/upload.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Cargar base de datos</h5>
                        <p class="card-text">
                            Modulo para cargar excel
                        </p>
                        <a href="javascript:void(0)" class="btn btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#excelUploadModal">Ingresar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <img class="card-img-top" src="../assets/informe.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Gestion de informes</h5>
                        <p class="card-text">
                            Informe
                        </p>
                        <a href="javascript:void(0)" onclick="cargar_contenido('contenido_principal', 'client/informe/informe_list.php')" class="btn btn-outline-primary float-end">Ingresar</a>
                    </div>
                </div>
            </div>
        </div>

<?php
    }
}
?>
<!-- Modal para cargar Excel -->
<div class="modal fade" id="excelUploadModal" tabindex="-1" aria-labelledby="excelUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="excelUploadModalLabel">Cargar Archivo Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="excelUploadForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="excelFile" class="form-label">Seleccionar archivo Excel</label>
                        <input type="file" class="form-control" id="excelFile" accept=".xlsx,.xls" required>
                        <div class="form-text">Solo se permiten archivos .xlsx y .xls</div>
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-primary float-end" id="loadPreviewBtn" disabled>
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Cargar Vista Previa
                        </button>
                    </div>

                    <!-- Área de vista previa -->
                    <div id="previewArea" class="d-none">
                        <h6>Vista Previa del Archivo:</h6>
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-striped table-sm" id="previewTable">
                                <thead id="previewTableHead"></thead>
                                <tbody id="previewTableBody"></tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-success" id="saveToDbBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                Guardar en Base de Datos
                            </button>
                            <button type="button" class="btn btn-secondary" id="loadAnotherBtn">Cargar Otro Archivo</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Intentar cargar XLSX desde múltiples fuentes -->
<script src="../js/client/load_excel/load_excel.js"></script>

<style>
    .swal-high-zindex {
        z-index: 10000 !important;
    }

    .swal2-container.swal-high-zindex {
        z-index: 10000 !important;
    }
</style>