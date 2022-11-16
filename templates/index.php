<?php
    require_once '../conections/basededatos.php';
    require_once '../Functions/sesion/confirm_existuser.php';
    require_once '../Functions/sesion/confirm_password.php';
    require_once '../entity/Usuario.php';
    //ini_set('session.gc_probability', 0);
    session_set_cookie_params(60*60*24*14);
    session_start();
    if(!isset($_SESSION['user_id'])){
        $usuario_page = new Usuario("a","b","c","d");
        try {
            /*if($_POST['email'] != null){
                $pass['confirmacion'] ? null : $mensaje_page->setAll("Ha ingresado un dato incorrecto", "warning");
            }*/
            $pass = confirm_password( $_POST['email'], $_POST['password'], $conn);
            $usuario_page->setById($pass['idUsuarios'], $conn);
            $_SESSION['user_id'] = $pass['idUsuarios'];
            $_SESSION['myuser_obj'] = $usuario_page;    
            //$_SESSION['mymessage_obj'] = $mensaje_page;
        } catch (\Throwable $th) {
            echo "no ingreso";//$_POST['password'] == null ? $mensaje_page->setAll(null, null) : $mensaje_page->setAll("Ha ingresado un dato incorrecto", "warning");
        }
    }
    
    //$alerta = new Alert($mensaje_page->getMessage(), $mensaje_page->getType());
?>

<?php require_once 'partials/headerhtml.php';?>
<?php if(!empty($_SESSION['user_id'])):?>
    <title>DirisLima</title>
    </head>
    <body>
        <div><a href="datosReporte/reporteDiario.php">ReporteDiario</a></div>
        <div><a href="">OTROS</a></div>
        <div><a href="../Functions/sesion/logout.php">Cerrar sesion</a></div>
        
    </body>
    </html>
<?php else: ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.scss">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
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
                    <div   class="invalid-feedback">Ingrese email</div>
                </div>
                <div class="input-group">
                    <label class="label">Contraseña </label>
                    <input type="password" name="password" id="password" class="input  form-control" required="" placeholder="Ingresa tu contraseña">
                    <div   class="invalid-feedback">Ingrese contraseña </div>
                </div>
                <div class="button-block">
                    <button type="submit" ><i class="fas fa-arrow-circle-right color_letra3"></i><span class="color_letra3">Iniciar Sesión</span></button>
                </div>
            </form>

        </div>

	</div>

</body>
</html>
<?php endif; ?>