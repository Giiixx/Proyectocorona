<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="../../index.php"><img src="../assets/images/logo.jpg" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="../../index.php"><img src="../assets/images/logo-mini.jpg" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="nav-profile-img">
                        <img src="../assets/images/enfermera.png" alt="image">
                        <span class="availability-status online"></span>
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black"><?= $_SESSION['myuser_obj']->getNombre() ?></p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <?php if ($_SESSION['myuser_obj']->getRol() == 3 or $_SESSION['myuser_obj']->getRol() == 1 ) { ?>
                    <a class="dropdown-item" href="../configuracion/vistasAllReportes.php">
                        <i class="mdi mdi-cached me-2 "></i> Configuracion </a>
                    <div class="dropdown-divider"></div>
                    <?php } ?>
                    <a class="dropdown-item" href="../../Functions/sesion/logout.php">
                        <i class="mdi mdi-logout me-2 "></i> Cerrar Sesion </a>
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
                        <img src="../assets/images/enfermera.png" alt="profile">
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
                    <span class="menu-title">Configuracion</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                            
                            <li class="nav-item"> <a class="nav-link" href="../configuracion/vistasAllReportes.php">Reportes De Establecimientos</a></li>
                            <li class="nav-item"> <a class="nav-link" href="../configuracion/editaranuncio.php">Modificar Anuncio</a></li>
                            <?php if ($_SESSION['myuser_obj']->getRol() == 3 ) { ?>
                            <li class="nav-item"> <a class="nav-link" href="../configuracion/registrarBiologicos.php">Registrar Biologico</a></li>
                            <li class="nav-item"> <a class="nav-link" href="../configuracion/cambiarContraseñas.php">Cambiar Contraseña</a></li>
                            <li class="nav-item"> <a class="nav-link" href="../configuracion/HabilitarEditarReporte.php">Habilitar Editar a Reporte</a></li>
                            <?php } ?>
                            
                    </ul>
                </div>
            </li>


        </ul>
    </nav>