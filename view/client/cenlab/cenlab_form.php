<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">📋 Formulario Centro Médico CENLAB</h5>
            </div>
            <div class="card-body">
                <form id="cenlabForm">
                    <div class="row">
                        <!-- Empresa -->
                        <div class="col-md-6 mb-3">
                            <label for="empresa" class="form-label">🏢 Nombre Empresa *</label>
                            <input type="text" class="form-control" id="empresa" name="empresa" required>
                        </div>
                        
                        <!-- Nombre Paciente -->
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">👤 Nombre Paciente *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        
                        <!-- Documento -->
                        <div class="col-md-6 mb-3">
                            <label for="documento" class="form-label">📄 Documento *</label>
                            <input type="text" class="form-control" id="documento" name="documento" required>
                        </div>
                        
                        <!-- Teléfono -->
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">📞 Teléfono *</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        
                        <!-- Tipo -->
                        <div class="col-md-6 mb-3">
                            <label for="tipo" class="form-label">🔬 Tipo de Examen *</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" required>
                        </div>
                        
                        <!-- Exámenes -->
                        <div class="col-md-6 mb-3">
                            <label for="examenes" class="form-label">🧪 Exámenes a Realizar *</label>
                            <textarea class="form-control" id="examenes" name="examenes" rows="3" required></textarea>
                        </div>
                        
                        <!-- Recomendaciones -->
                        <div class="col-md-12 mb-3">
                            <label for="recomendaciones" class="form-label">💡 Recomendaciones *</label>
                            <textarea class="form-control" id="recomendaciones" name="recomendaciones" rows="3" required></textarea>
                        </div>
                        
                        <!-- Correos -->
                        <div class="col-md-6 mb-3">
                            <label for="correo" class="form-label">📧 Correo Principal *</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="correo_copia" class="form-label">📧 Correo Copia (Opcional)</label>
                            <input type="email" class="form-control" id="correo_copia" name="correo_copia">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="correo_copia_s" class="form-label">📧 Correo Copia Secundario (Opcional)</label>
                            <input type="email" class="form-control" id="correo_copia_s" name="correo_copia_s">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="correo_copia_t" class="form-label">📧 Correo Copia Terciario (Opcional)</label>
                            <input type="email" class="form-control" id="correo_copia_t" name="correo_copia_t">
                        </div>
                        
                        <!-- Fecha -->
                        <div class="col-md-6 mb-3">
                            <label for="fecha" class="form-label">📅 Fecha de Cita *</label>
                            <input type="datetime-local" class="form-control" id="fecha" name="fecha" required>
                        </div>
                        
                        <!-- Ciudad -->
                        <div class="col-md-6 mb-3">
                            <label for="ciudad" class="form-label">🏙️ Ciudad *</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                        </div>
                        
                        <!-- Lugar -->
                        <div class="col-md-12 mb-3">
                            <label for="lugar" class="form-label">📍 Lugar de Atención *</label>
                            <input type="text" class="form-control" id="lugar" name="lugar" required>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-info w-100" onclick="generateMessagePreview()">
                                👁️ Vista Previa del Mensaje
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button onclick="submitCenlabForm()" class="btn btn-success w-100">
                                💾 Guardar Información
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Vista Previa -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">📱 Vista Previa del Mensaje WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="whatsapp-preview" style="background-color: #e5ddd5; padding: 20px; border-radius: 10px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    <div class="message-bubble" style="background-color: #dcf8c6; padding: 15px; border-radius: 10px; margin: 10px 0; white-space: pre-line;" id="messagePreview">
                        <!-- El mensaje se generará aquí -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="../js/client/cenlab_form/cenlab_form.js"></script>
