<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"></li>
                <li class="menu-title"></li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Gestion General</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa-solid fa-syringe"></i><a href="../datosReporte/reporteDiario.php">Nuevo Reporte</a></li>
                        <li><i class="fa-solid fa-pen-to-square"></i><a href="../datosBiologico/registrarBiologicos.php">Registrar Biologico</a></li>
                        <li><i class="fa-solid fa-magnifying-glass"></i><a href="../datosReporte/editarReporteDiario.php">Editar envio</a></li>
                        <li><i class="fa-solid fa-globe "></i><a class="vistadefecto" href="../vistas/vistaReporteDiario.php">Vista Reportes</a></li>
                        <li><i class="fa-solid fa-globe "></i><a class="vistadefecto" href="../vistas/vistaReporteMes.php">Vista Reportes MES</a></li>
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
                <a class="navbar-brand" href="./"><img src="../assets/images/ministeriodesalud.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="" alt="Logo"></a>
                <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            </div>
        </div>
        <div class="top-right">
            <div class="header-menu">


                <div class="user-area dropdown float-right">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <h2>
                        <?= $_SESSION['myuser_obj']->getNombre()?>
                        </h2>
                        <img class="user-avatar rounded-circle" src="../assets/images/usuario.png" alt="User Avatar">
                    </a>

                    <div class="user-menu dropdown-menu">
                        <a class="nav-link" href="#"><i class="fa-solid fa-user-gear"></i>Configuración</a>

                        <a class="nav-link" href="../../Functions/sesion/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Cerrar Sesion </a>

                    </div>
                </div>

            </div>
        </div>
    </header>
    