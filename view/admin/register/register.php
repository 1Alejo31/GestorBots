<!-- Content -->
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register Card -->
            <div class="">
                <div class="">

                    <h4 class="mb-2">Registro de Usuario</h4>
                    <p class="mb-4">Complete todos los campos para crear su cuenta</p>

                    <form id="formRegister" class="needs-validation">
                        <!-- Información Personal -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="bx bx-user me-2"></i>Información Personal</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="primer_nombre">Primer Nombre *</label>
                                        <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" placeholder="Ingrese su primer nombre" required />
                                        <div class="valid-feedback">¡Perfecto!</div>
                                        <div class="invalid-feedback">Por favor ingrese su primer nombre.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="segundo_nombre">Segundo Nombre</label>
                                        <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre" placeholder="Ingrese su segundo nombre (opcional)" />
                                        <div class="valid-feedback">¡Perfecto!</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="primer_apellido">Primer Apellido *</label>
                                        <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" placeholder="Ingrese su primer apellido" required />
                                        <div class="valid-feedback">¡Perfecto!</div>
                                        <div class="invalid-feedback">Por favor ingrese su primer apellido.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="segundo_apellido">Segundo Apellido</label>
                                        <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" placeholder="Ingrese su segundo apellido (opcional)" />
                                        <div class="valid-feedback">¡Perfecto!</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="fecha_nacimiento">Fecha de Nacimiento *</label>
                                        <input type="text" class="form-control flatpickr-validation" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Seleccione su fecha de nacimiento" required />
                                        <div class="valid-feedback">¡Perfecto!</div>
                                        <div class="invalid-feedback">Por favor seleccione su fecha de nacimiento.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="telefono_movil">Teléfono Móvil *</label>
                                        <input type="tel" class="form-control" id="telefono_movil" name="telefono_movil" placeholder="Ej: +57 300 123 4567" required />
                                        <div class="valid-feedback">¡Perfecto!</div>
                                        <div class="invalid-feedback">Por favor ingrese un número de teléfono válido.</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="tipo_documento">Tipo de Documento *</label>
                                        <select class="form-select" id="tipo_documento" name="tipo_documento" required>
                                            <option value="">Seleccione tipo de documento</option>
                                            <option value="CC">Cédula de Ciudadanía</option>
                                            <option value="CE">Cédula de Extranjería</option>
                                            <option value="TI">Tarjeta de Identidad</option>
                                            <option value="PP">Pasaporte</option>
                                            <option value="NIT">NIT</option>
                                        </select>
                                        <div class="valid-feedback">¡Perfecto!</div>
                                        <div class="invalid-feedback">Por favor seleccione el tipo de documento.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="documento">Número de Documento *</label>
                                        <input type="text" class="form-control" id="documento" name="documento" placeholder="Ingrese su número de documento" required />
                                        <div class="valid-feedback">¡Perfecto!</div>
                                        <div class="invalid-feedback">Por favor ingrese su número de documento.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Cuenta -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="bx bx-envelope me-2"></i>Información de Cuenta</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="email">Correo Electrónico *</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="correo@ejemplo.com" required />
                                    <div class="valid-feedback">¡Perfecto!</div>
                                    <div class="invalid-feedback">Por favor ingrese un correo electrónico válido.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password">Contraseña</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password"
                                            class="form-control readonly-field"
                                            id="password"
                                            name="password"
                                            placeholder="Se auto-completará con el documento"
                                            autocomplete="current-password"
                                            readonly>
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-lock"></i></span>
                                    </div>
                                    <small class="text-muted">La contraseña se genera automáticamente con su número de documento</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="tipo_usuario">Tipo de Usuario *</label>
                                        <select class="form-select" id="tipo_usuario" name="tipo_usuario" required>
                                            <option value="">Seleccione tipo de usuario</option>
                                            <option value="admin">Administrador</option>
                                            <option value="cliente">Cliente</option>
                                            <option value="operador">Operador</option>
                                            <option value="supervisor">Supervisor</option>
                                        </select>
                                        <div class="valid-feedback">¡Perfecto!</div>
                                        <div class="invalid-feedback">Por favor seleccione el tipo de usuario.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="tipo_servicio">Tipo de Servicio *</label>
                                        <select class="form-select" id="tipo_servicio" name="tipo_servicio" required>
                                            <option value="">Seleccione tipo de servicio</option>
                                            <option value="basico">Básico</option>
                                            <option value="premium">Premium</option>
                                            <option value="empresarial">Empresarial</option>
                                            <option value="personalizado">Personalizado</option>
                                        </select>
                                        <div class="valid-feedback">¡Perfecto!</div>
                                        <div class="invalid-feedback">Por favor seleccione el tipo de servicio.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Empresa -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="bx bx-buildings me-2"></i>Información de Empresa</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="nombre_empresa">Nombre de la Empresa *</label>
                                        <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" placeholder="Ingrese el nombre de la empresa" required />
                                        <div class="valid-feedback">¡Perfecto!</div>
                                        <div class="invalid-feedback">Por favor ingrese el nombre de la empresa.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="nit_empresa">NIT de la Empresa *</label>
                                        <input type="text" class="form-control" id="nit_empresa" name="nit_empresa" placeholder="Ingrese el NIT de la empresa" required />
                                        <div class="valid-feedback">¡Perfecto!</div>
                                        <div class="invalid-feedback">Por favor ingrese el NIT de la empresa.</div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="direccion_empresa">Dirección de la Empresa *</label>
                                    <textarea class="form-control" id="direccion_empresa" name="direccion_empresa" rows="2" placeholder="Ingrese la dirección completa de la empresa" required></textarea>
                                    <div class="valid-feedback">¡Perfecto!</div>
                                    <div class="invalid-feedback">Por favor ingrese la dirección de la empresa.</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="telefono_movil_e">Teléfono Móvil *</label>
                                        <input type="tel" class="form-control" id="telefono_movil_e" name="telefono_movil_e" placeholder="Ej: +57 300 123 4567" required />
                                        <div class="valid-feedback">¡Perfecto!</div>
                                        <div class="invalid-feedback">Por favor ingrese un número de teléfono válido.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="url_pagina">URL de la Página Web</label>
                                        <input type="url" class="form-control" id="url_pagina" name="url_pagina" placeholder="https://www.ejemplo.com (opcional)" />
                                        <div class="valid-feedback">¡Perfecto!</div>
                                        <div class="invalid-feedback">Por favor ingrese una URL válida.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="guardarUsuario()" class="btn btn-primary d-grid w-100 mb-3">
                            <span class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-user-plus me-2"></i>
                                Registrar Usuario
                            </span>
                        </button>
                    </form>
                </div>
            </div>
            <!-- /Register Card -->
        </div>
    </div>
</div>
<!-- /Content -->

<!-- Scripts -->
<script src="../plantilla/assets/vendor/libs/jquery/jquery.js"></script>
<script src="../js/admin/register/register_user.js"></script>
<script src="../plantilla/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
<!-- Page JS -->
<script>
    'use strict';

    (function() {
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

        documentoInput.addEventListener('input', function() {
            passwordInput.value = this.value;
        });

        const urlInput = document.getElementById('url-pagina');
        urlInput.addEventListener('blur', function() {
            if (this.value && !this.value.match(/^https?:\/\/.+/)) {
                this.setCustomValidity('La URL debe comenzar con http:// o https://');
            } else {
                this.setCustomValidity('');
            }
        });

        // Validación de teléfono
        const telefonoInput = document.getElementById('telefono-movil');
        telefonoInput.addEventListener('input', function() {
            // Permitir solo números, espacios, + y -
            this.value = this.value.replace(/[^0-9\s\+\-]/g, '');
        });

        // Validación de NIT
        const nitInput = document.getElementById('nit-empresa');
        nitInput.addEventListener('input', function() {
            // Permitir solo números y guiones
            this.value = this.value.replace(/[^0-9\-]/g, '');
        });

    })();
</script>