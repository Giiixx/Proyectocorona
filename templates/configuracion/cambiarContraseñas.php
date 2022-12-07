<?php
require_once '../../conections/basededatos.php';
require_once '../../entity/ListaDetalleReporte.php';
require_once '../../entity/Usuario.php';
require_once '../../Functions/sesion/confirm_existuser.php';
require_once '../../Functions/sesion/confirm_password.php';

session_start();
isset($_SESSION['user_id']) ? null : header('Location: ../../index.php');
confirm_existuser($_SESSION['user_id'], $conn) == FALSE ? header('Location:../../index.php') : null;

$listaFechas = new ListaDetalleReporte($conn);
$detalleReporte = new ListaDetalleReporte($conn);
date_default_timezone_set("America/Bogota");
$idUsuario = $_SESSION["myuser_obj"]->getId();

$detalleReporte->SearchReportesEstablecimientos($conn);

$_SESSION['myuser_obj']->getRol() == 3 ? null : header('Location: ../../index.php');


?>


<?php require '../partials/headerhtmlconfiguracion.php' ?>

<?php if (!empty($_SESSION['user_id'])) : ?>
    <title>Cambiar Contraseñas de Usuarios</title>
    </head>

    <body>

        <?php require '../partials/navbarConfiguracion.php' ?>
        <div class="main-panel position-relative">
            
            <form class="translate-">
                
                <label class="form-label">Seleccionar Establecimiento </label>
                <select class="combousuarios" name="combousuarios" id="combousuarios">
                    <?php foreach ($detalleReporte->lista as $valor => $value) { ?>
                        <option class="opcion">
                            <?php echo $detalleReporte->lista[$valor]['UsuariosDescEstablecimiento'] ?></option>
                    <?php } ?>
                </select>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="text" class="form-control" id="pass">
                    <div class="validarErrores" id="MensajeError">Ingresar un Contraseña</div>
                </div>
                
                <button  class="btn btn-primary contraseña">Cambiar Contraseña</button>
            </form>


        </div>
        </div>
        <script src="../assets/js/vendor.bundle.base.js"></script>
        <script src="../assets/js/off-canvas.js"></script>
        <script src="../assets/js/hoverable-collapse.js"></script>
        <script src="../assets/js/misc.js"></script>
        <script src="../assets/js/scripts.js"></script>
        <script src="../assets/js/jquery.js"></script>
        <script src="../assets/js/jquery-ui.js"></script>
        <script src="../assets/js/cambiarcontraseña.js"></script>

    <?php endif; ?>
    </body>

    </html>