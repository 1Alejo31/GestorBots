<?php

require '../controller/gestorSession/gestorSession.php';

$gestor = new GestorSession();
$gestor->statusSesion();

?>
<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../plantilla/assets/"
    data-template="horizontal-menu-template-no-customizer-starter">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Gestor Bots</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="../plantilla/assets/vendor/fonts/boxicons.css" />
    <!-- <link rel="stylesheet" href="../plantilla/assets/vendor/fonts/fontawesome.css" /> -->
    <!-- <link rel="stylesheet" href="../plantilla/assets/vendor/fonts/flag-icons.css" /> -->

    <!-- Core CSS -->
    <link rel="stylesheet" href="../plantilla/assets/vendor/css/rtl/core.css" />
    <link rel="stylesheet" href="../plantilla/assets/vendor/css/rtl/theme-default.css" />
    <link rel="stylesheet" href="../plantilla/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../plantilla/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../plantilla/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../plantilla/assets/js/config.js"></script>
    <!-- Agregar antes del cierre de </head> -->
    <script src="../plantilla/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <link rel="stylesheet" href="../plantilla/assets/vendor/libs/sweetalert2/sweetalert2.css">
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->
            <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="container-xxl">
                    <div class="navbar-brand  ">
                        <a href="index.html" class="app-brand-link gap-2">
                            <img src="../assets/logo.png" alt="" width="25%">
                            <span class="app-brand-text demo menu-text fw-bold">RPA</span>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="../plantilla/assets/img/avatars/1.png" alt class="rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="../plantilla/assets/img/avatars/1.png" alt class="rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium d-block lh-1">John Doe</span>
                                                    <small>Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="../controller/login/logout.php">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- / Navbar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Menu -->
                    <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
                        <div class="container-xxl d-flex h-100">
                            <ul class="menu-inner py-1">
                                <!-- Page -->
                                <li class="menu-item active">
                                    <a onclick="cargar_contenido('contenido_principal', 'inicio/inicio.php')" class="menu-link">
                                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                        <div data-i18n="Page 1">Inicio</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </aside>
                    <!-- / Menu -->

                    <div class="container-xxl flex-grow-1 container-p-y" id="contenido_principal" style="margin-top: 20px;">

                    </div>
                    <!--/ Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <span id="current-year"></span>
                                , hecho con ❤️ por
                                <a href="https://www.aguisu.com/" target="_blank" class="footer-link fw-medium">Aguisu</a>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <script>
                        // Alternativa moderna a document.write()
                        document.addEventListener('DOMContentLoaded', function() {
                            document.getElementById('current-year').textContent = new Date().getFullYear();
                        });
                    </script>

                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>

            <!--/ Layout container -->
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="../plantilla/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../plantilla/assets/vendor/libs/popper/popper.js"></script>
    <script src="../plantilla/assets/vendor/js/bootstrap.js"></script>
    <script src="../plantilla/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../plantilla/assets/vendor/libs/hammer/hammer.js"></script>

    <!-- endbuild -->

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <!-- Vendors JS -->
    <!-- Remover esta línea que causa el error -->
    <!-- <script src="../plantilla/assets/vendor/libs/flatpickr/locales/es.js"></script> -->

    <!-- Agregar Flatpickr CSS y JS -->
    <link rel="stylesheet" href="../plantilla/assets/vendor/libs/flatpickr/flatpickr.css" />
    <script src="../plantilla/assets/vendor/libs/flatpickr/flatpickr.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            cargar_contenido('contenido_principal', 'inicio/inicio.php');
        });

        function cargar_contenido(id, vista) {
            const elemento = document.getElementById(id);

            if (!elemento) {
                console.log(`Elemento con el id ${id} no encontrado`);
                return;
            }

            fetch(vista)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Http error! Estado : ${response.status}`);
                    }
                    return response.text();
                })
                .then(data => {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data;

                    elemento.innerHTML = tempDiv.innerHTML;

                    const scripts = tempDiv.querySelectorAll('script');
                    scripts.forEach(script => {
                        const newScript = document.createElement('script');
                        if (script.src) {
                            // Si el script tiene un src, copia el atributo src
                            newScript.src = script.src;
                            newScript.onload = function() {
                                // Llamar función de inicialización específica para gestor_message
                                if (script.src.includes('gestor_message.js') && typeof inicializarGestorMessage === 'function') {
                                    inicializarGestorMessage();
                                }
                            };
                        } else {
                            // Si el script no tiene src, copia el contenido
                            newScript.textContent = script.textContent;
                        }
                        document.body.appendChild(newScript).parentNode.removeChild(newScript);
                    });
                })
                .catch(error => {
                    console.error(`Error al cargar el contenido: ${error}`);
                })
        }
    </script>
</body>

</html>