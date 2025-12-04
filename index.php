<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="plantilla/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login - GestorBots</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="plantilla/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="plantilla/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="plantilla/assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="plantilla/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="plantilla/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="plantilla/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="plantilla/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="plantilla/assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="plantilla/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="plantilla/assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="plantilla/assets/vendor/js/helpers.js"></script>
    <script src="plantilla/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <link rel="stylesheet" href="plantilla/assets/vendor/libs/sweetalert2/sweetalert2.css">
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="plantilla/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="plantilla/assets/js/config.js"></script>

    <!-- Custom styles for background image and layout -->
    <style>
        body {
            background-image: url('assets/fono.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 450px;
            width: 100%;
            margin-left: 5%;
        }

        @media (max-width: 768px) {
            .login-container {
                justify-content: center;
                padding: 1rem;
            }

            .login-card {
                margin-left: 0;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Content -->
    <div class="login-container">
        <div class="login-card">
            <div class="card-body p-4 p-sm-5">
                <!-- Logo -->
                <div class="app-brand mb-4 text-center">
                    <a href="index.html" class="app-brand-link gap-2 mb-2">
                        <img src="assets/logo.png" alt="logo" width="50" height="50" />
                        <span class="app-brand-text demo h3 mb-0 fw-bold">Gestor Bots</span>
                    </a>
                </div>
                <!-- /Logo -->

                <div class="text-center mb-4">
                    <h4 class="mb-2">¡Bienvenido a Gestor Bots! 👋</h4>
                    <p class="mb-0">Por favor inicia sesión en tu cuenta para comenzar</p>
                </div>


                <div class="mb-3">
                    <label for="text_usuario" class="form-label">Email o Usuario</label>
                    <input type="text" class="form-control" id="text_usuario" name="text_usuario"
                        placeholder="Ingresa tu email o usuario" autofocus />
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Contraseña</label>
                        <a href="forgot-password.html">
                            <small>¿Olvidaste tu contraseña?</small>
                        </a>
                    </div>
                    <div class="input-group input-group-merge">
                        <input type="password" id="text_pass" class="form-control" name="text_pass"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" />
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember-me" />
                        <label class="form-check-label" for="remember-me"> Recordarme </label>
                    </div>
                </div>
                <button onclick="iniciar_sesion()" class="btn btn-primary d-grid w-100 mb-3">Iniciar Sesión</button>

            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="js/login/login.js"></script>
    <script src="plantilla/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="plantilla/assets/vendor/libs/popper/popper.js"></script>
    <script src="plantilla/assets/vendor/js/bootstrap.js"></script>
    <script src="plantilla/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="plantilla/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="plantilla/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="plantilla/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="plantilla/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="plantilla/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="plantilla/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="plantilla/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>

    <!-- Main JS -->
    <script src="plantilla/assets/js/main.js"></script>
</body>

</html>