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
        <div class="main-panel navbar-nav-scroll">

            <div class="conteiner-cambiarcontra">
                <form class="cambiarcontra">
                    <div class="mb-3">
                        <label class="form-label">Establecimiento </label>
                        <select class="combousuarios form-control" name="combousuarios" id="combousuarios">
                            <option class="opcion">Seleccionar Establecimiento</option>
                            <?php foreach ($detalleReporte->lista as $valor => $value) { ?>
                                <option class="opcion">
                                    <?php echo $detalleReporte->lista[$valor]['UsuariosDescEstablecimiento'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="validarErrores" id="MensajeError1">Seleccionar un Establecimiento</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control"  id="pass">
                        <div class="validarErrores" id="MensajeError">Ingresar una Contraseña</div>
                    </div>
                    <div class="mb-3">
                        <button class="contraseña">Cambiar Contraseña</button>
                    </div>
                </form>
            </div>


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