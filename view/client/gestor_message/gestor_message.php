<?php
session_start();
?>
<div id="estadisticas" class="row" hidden>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                    <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-truck"></i></span>
                    </div>
                    <h4 class="ms-1 mb-0">42</h4>
                </div>
                <p class="mb-1">Whatsapp enviados</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card card-border-shadow-warning h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                    <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-error"></i></span>
                    </div>
                    <h4 class="ms-1 mb-0">8</h4>
                </div>
                <p class="mb-1">Whatsapp por enviar</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card card-border-shadow-danger h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                    <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-git-repo-forked"></i></span>
                    </div>
                    <h4 class="ms-1 mb-0">27</h4>
                </div>
                <p class="mb-1">Correos por enviar</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
        <div class="card card-border-shadow-info h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                    <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-info"><i class="bx bx-time-five"></i></span>
                    </div>
                    <h4 class="ms-1 mb-0">23</h4>
                </div>
                <p class="mb-1">Correos enviados</p>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-xxl-12 mb-12 order-1 order-xxl-3">
    <div class="card h-100" id="whatsappCard" style="position: relative; background-image: url('../assets/whatsapp.png'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 500px; transition: background-image 1s ease-in-out;">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div style="background-color:rgba(255, 255, 255, 0.4); padding: 15px 25px; border-radius: 8px;">
                <h5 class="m-0 me-2" id="tituloWhatsapp" style="font-size: 1.3rem; color: #ffffff;">Loguear cuenta whatsapp</h5>
            </div>
        </div>
        <br>
        <div class="card-body">
            <div class="row">
                <?php
                if (trim($_SESSION['T_US']) == 'cliente' && trim($_SESSION['T_CL']) == "Personalizado") {
                ?>
                    <div class="col-md-6 mx-auto" id="formularioInicio">
                        <div class="card-body d-flex justify-content-center">
                            <div class="form-group" style="background-color:rgba(255, 255, 255, 0.4); padding: 20px; border-radius: 8px; width: 75%;">
                                <p>Bot de Envio</p>
                                <img id="qrImage" src="../controller/uploads/SenLabQr1.png" alt="logo" style="width: 75%; display: block; margin: 0 auto;">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mx-auto" id="formularioInicio">
                        <div class="card-body d-flex justify-content-center">
                            <div class="form-group" style="background-color:rgba(255, 255, 255, 0.4); padding: 20px; border-radius: 8px; width: 75%;">
                                <p>Bot de Gestion</p>
                                <img id="qrImage2" src="../controller/uploads/SenLabQr2.png" alt="logo" style="width: 75%; display: block; margin: 0 auto;">
                            </div>
                        </div>
                    </div>
                <?php
                } else if (trim($_SESSION['T_US']) == 'cliente' && trim($_SESSION['T_CL']) == "basico") {
                ?>
                    <div class="col-md-6 mx-auto" id="formularioInicio">
                        <div class="card-body d-flex justify-content-center">
                            <div class="form-group" style="background-color:rgba(255, 255, 255, 0.4); padding: 20px; border-radius: 8px; width: 75%;">
                                <p>Bot de Envio</p>
                                <img id="qrImage" src="../controller/uploads/qr4.png" alt="logo" style="width: 75%; display: block; margin: 0 auto;">
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="col-md-6 mx-auto" id="formularioInicio">
                        <div class="card-body d-flex justify-content-center">
                            <div class="form-group" style="background-color:rgba(255, 255, 255, 0.4); padding: 20px; border-radius: 8px; width: 75%;">
                                <p>Bot de Envio</p>
                                <img id="qrImage" src="../controller/uploads/qr2.png" alt="logo" style="width: 75%; display: block; margin: 0 auto;">
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <div class="col-md-12 mx-auto" id="codigoDeInicio">
                    <button id="confirmacion" class="btn" onclick="btnConfirmar()" style="background-color: #4F9D3C; color: #ffffff; display: block; margin: 0 auto;">Confirmar</button>
                </div>


            </div>
        </div>
    </div>

    <script src="../js/client/gestor_message/gestor_message.js"></script>
    <script>
        <?php
        if ($_SESSION['T_US'] === 'cliente' && $_SESSION['T_CL'] === "Personalizado") {
        ?>
            setInterval(function() {
                document.getElementById('qrImage').src = '../controller/uploads/SenLabQr1.png?' + Math.random();
                document.getElementById('qrImage2').src = '../controller/uploads/SenLabQr2.png?' + Math.random();
            }, 500);
        <?php
        } else if ($_SESSION['T_US'] === 'cliente' && $_SESSION['T_CL'] === "basico") {
        ?>
            setInterval(function() {
                document.getElementById('qrImage').src = '../controller/uploads/qr4.png?' + Math.random();
            }, 500);
        <?php
        } else {
        ?>
            setInterval(function() {
                document.getElementById('qrImage').src = '../controller/uploads/qr2.png?' + Math.random();
            }, 500);
        <?php
        }
        ?>
    </script>