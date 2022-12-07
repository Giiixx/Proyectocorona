<?php
require_once 'conections/basededatos.php';
require_once 'Functions/sesion/confirm_existuser.php';
require_once 'Functions/sesion/confirm_password.php';
require_once 'entity/Usuario.php';
//ini_set('session.gc_probability', 0);
session_set_cookie_params(60 * 60 * 24 * 14);
session_start();
if (!isset($_SESSION['user_id'])) {
    $usuario_page = new Usuario("a", "b", "c", "d");
    try {
        /*if($_POST['email'] != null){
                $pass['confirmacion'] ? null : $mensaje_page->setAll("Ha ingresado un dato incorrecto", "warning");
            }*/
        $pass = confirm_password($_POST['email'], $_POST['password'], $conn);
        $usuario_page->setById($pass['idUsuarios'], $conn);
        $_SESSION['user_id'] = $pass['idUsuarios'];
        $_SESSION['myuser_obj'] = $usuario_page;
        //$_SESSION['mymessage_obj'] = $mensaje_page;
    } catch (\Throwable $th) {
        echo "no ingreso"; //$_POST['password'] == null ? $mensaje_page->setAll(null, null) : $mensaje_page->setAll("Ha ingresado un dato incorrecto", "warning");
    }
}  
$_SESSION['myuser_obj']->getRol() == 3 ? header('Location: templates/configuracion/vistasAllReportes.php') : header('Location:');
//$alerta = new Alert($mensaje_page->getMessage(), $mensaje_page->getType());
?>

<?php if (!empty($_SESSION['user_id'])) : ?>
    <?php
    require_once 'conections/basededatos.php';
    require_once 'entity/ListaDetalleReporte.php';
    require_once 'entity/Usuario.php';

    $detalleReporte = new ListaDetalleReporte($conn);
    date_default_timezone_set("America/Bogota");
    $fecha_actual = date("Y-m-d");
    $idUsuario = $_SESSION["myuser_obj"]->getId();

    $detalleReporte->SearchReporteById($conn, $_SESSION["myuser_obj"]->getId());
    $habilitar = $detalleReporte->SearchReporteByIdBool($conn, $idUsuario) ? ($detalleReporte->reporte['ReporteApertura'] > $fecha_actual ? FALSE : TRUE) : TRUE;

    $detalleReporte->SearchDetallesReporteHabilitados($conn, $_SESSION["myuser_obj"]->getId(), $detalleReporte->reporte['idReporte']);
    $habilitar2 = empty($detalleReporte->lista) ? FALSE : TRUE;

    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="templates/assets/vendors/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="templates/assets/css/dash.css">
        <link rel="shortcut icon" href="templates/assets/images/favicon.ico" />
        <title>DirisLima</title>
    </head>

    <body>


        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href=""><img src="templates/assets/images/logo.jpg" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href=""><img src="templates/assets/images/logo-mini.jpg" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="nav-profile-img">
                                <img src="templates/assets/images/enfermera.png" alt="image">
                                <span class="availability-status online"></span>
                            </div>
                            <div class="nav-profile-text">
                                <p class="mb-1 text-black"><?= $_SESSION['myuser_obj']->getNombre() ?></p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                            <?php if ($_SESSION['myuser_obj']->getRol() == 1 ) { ?>
                            <a class="dropdown-item" href="templates/configuracion/vistasAllReportes.php">
                                <i class="mdi mdi-cached me-2 text-success"></i> Configuracion </a>
                            <div class="dropdown-divider"></div>
                            <?php } ?>
                            <a class="dropdown-item" href="Functions/sesion/logout.php">
                                <i class="mdi mdi-logout me-2 text-primary"></i> Cerrar Sesion </a>
                        </div>
                    </li>

                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <a href="#" class="nav-link">
                            <div class="nav-profile-image">
                                <img src="templates/assets/images/enfermera.png" alt="profile">
                                <span class="login-status online"></span>
                                <!--change to offline or busy as needed-->
                            </div>
                            <div class="nav-profile-text d-flex flex-column">
                                <span class="font-weight-bold mb-2"><?= $_SESSION['myuser_obj']->getNombre() ?></span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-title">Reporte</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <?php if ($habilitar) { ?>
                                    <li class="nav-item"><a class="nav-link" href="templates/datosReporte/reporteMes.php">Reportes Mensual</a></li>
                                    <li class="nav-item"><a class="nav-link" href="templates/datosReporte/reporteDiario.php">Reporte Diario</a></li>
                                    <li class="nav-item"><a class="nav-link" href="templates/datosReporte/editarReporteDiario.php">Editar Reporte del dia Anterior</a></li>
                                    <?php if ($habilitar2) { ?>
                                        <li class="nav-item"><a class="nav-link" href="templates  /datosReporte/editarReporteHabilitado.php">Editar Reportes Habilitado</a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                            <span class="menu-title">Ver Reportes</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                        </a>
                        <div class="collapse" id="general-pages">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="templates/vistas/vistaReporteDiario.php">Vista Reportes Diarios</a></li>
                                <li class="nav-item"> <a class="nav-link" href="templates/vistas/vistaReporteMes.php">Vista Reportes Mensuales</a></li>
                            </ul>
                        </div>
                    </li>


                </ul>
            </nav>
            <div class="main-panel">
                <embed src="archives/e-commerce.pdf" type="application/pdf" width="320px" height="630px">

            </div>
        </div>

        <script src="templates/assets/js/vendor.bundle.base.js"></script>
        <script src="templates/assets/js/off-canvas.js"></script>
        <script src="templates/assets/js/hoverable-collapse.js"></script>
        <script src="templates/assets/js/misc.js"></script>

    </body>

    </html>


<?php else : ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="templates/assets/css/login.css">
        <link rel="stylesheet" href="templates/assets/css/bootstrap.min.css">
        <title>Login</title>
    </head>

    <body>

        <div class="container-l">
            <div class="content d-flex">
                <div class="background-img d-flex align-items-center">

                </div>

                <form action="index.php" class="miForm needs-validation" method="post">

                    <div class="input-group">
                        <label class="label">Usuario </label>
                        <input type="text" name="email" class="form-control" required="true" placeholder="Ingresa tu usuario">
                        <div class="invalid-feedback">Ingrese email</div>
                    </div>
                    <div class="input-group">
                        <label class="label">Contraseña </label>
                        <input type="password" name="password" id="password" class="input  form-control" required="" placeholder="Ingresa tu contraseña">
                        <div class="invalid-feedback">Ingrese contraseña </div>
                    </div>
                    <div class="button-block">
                        <button type="submit"><i class="fas fa-arrow-circle-right color_letra3"></i><span class="color_letra3">Iniciar Sesión</span></button>
                    </div>
                </form>

            </div>

        </div>
    </body>

    </html>

<?php endif; ?>