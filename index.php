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

//$alerta = new Alert($mensaje_page->getMessage(), $mensaje_page->getType());
?>

<?php if (!empty($_SESSION['user_id'])) : ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="stylesheet" href="templates/assets/css/dash.css">
        <title>DirisLima</title>
    </head>

    <body>
        <aside id="left-panel" class="left-panel">
            <nav class="navbar navbar-expand-sm navbar-default">
                <div id="main-menu" class="main-menu collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"></li>
                        <li class="menu-title"></li>
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Gestion General</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="fa-solid fa-syringe"></i><a href="templates/datosReporte/reporteDiario.php">Nuevo Reporte</a></li>
                                <li><i class="fa-solid fa-pen-to-square"></i><a href="templates/datosBiologico/registrarBiologicos.php">Registrar Biologico</a></li>
                                <li><i class="fa-solid fa-globe"></i><a href="templates/datosReporte/editarReporteDiario.php">Editar envio</a></li>
                                <li><i class="fa-solid fa-magnifying-glass"></i><a class="vistadefecto" href="templates/vistas/vistaReporteDiario.php">Vista Reportes</a></li>
                                <li><i class="fa-solid fa-magnifying-glass"></i><a class="vistadefecto" href="templates/vistas/vistaReporteMes.php">Vista Reportes</a></li>

                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>
        <div id="right-panel" class="right-panel">
            <!-- Header-->
            <header id="header" class="header">
                <div class="top-left">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="./"><img src="templates/assets/images/ministeriodesalud.png" alt="Logo"></a>
                        <a class="navbar-brand hidden" href="./"><img src="" alt="Logo"></a>
                        <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
                <div class="top-right">
                    <div class="header-menu">


                        <div class="user-area dropdown float-right">
                            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $_SESSION['myuser_obj']->getNombre() ?>
                                <img class="user-avatar rounded-circle" src="templates/assets/images/usuario.png" alt="User Avatar">
                            </a>

                            <div class="user-menu dropdown-menu">
                                <a class="nav-link" href="#"><i class="fa-solid fa-user-gear"></i>Configuración</a>

                                <a class="nav-link" href="Functions/sesion/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Cerrar Sesion </a>

                            </div>
                        </div>

                    </div>
                </div>
            </header>
            <div class="clearfix">

            </div>

        </div>
        <script src="templates/assets/js/jquery.js"></script>
        <script src="templates/assets/js/vistaReporte.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
        <script src="templates/assets/js/dash.js"></script>

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