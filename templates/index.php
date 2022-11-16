<?php
    require_once '../conections/basededatos.php';
    require_once '../Functions/sesion/confirm_existuser.php';
    require_once '../Functions/sesion/confirm_password.php';
    require_once '../entity/Usuario.php';
    //ini_set('session.gc_probability', 0);
    session_set_cookie_params(60*60*24*14);
    session_start();
    echo ("ola");
    echo ($_SESSION['user_id']);
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
<?php if(!empty($_SESSION['user_id'])):?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        olaolaolaolaolaolaolaolaola
        <form action="../Functions/sesion/logout.php">
            <button > cerrar sesion</button>
        </form>
        
        
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
<<<<<<< HEAD
<div>
    <div class="contenedor_add">
        <button  class="ref" data-bs-toggle="modal" data-bs-target="#modalForm"><i class="fas fa-plus"></i>&nbsp&nbspAgregar Biologico</button>
    </div>    
    <!-- Modal Registrar -->
    <div class="modal fade m_1" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog m_2">
            <div class="modal-content m_3">
                <div class="modal-header m_4">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar nueva Biologico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m_4_1">
                    <form action="../Functions/AddDetalleReporte.php" method="post">
                        <div class="mb-3">
                            <label class="form-label">Descripcion Biologico</label>
                            <select class="comboboxRegistrar"  name="DetalleBiologico" id="DetalleBiologico" >
                                <option value="">Seleecionar</option>
                            <?php foreach($productos->productos as $valor=>$value){?>
                                <option  class="opcion">
                                <?php echo $productos->getNombre($valor) ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Ingresos</label>
                            <input type="number" class="form-control"  id="ingreso" name="ingreso" placeholder="Ingresos..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Ingresos Extra</label>
                            <input type="number" class="form-control"  id="ingresoextra" name="ingresoextra" placeholder="Ingresos Extra..."/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Frascos Abiertos</label>
                            <input type="number" class="form-control" id="frascoabierto" name="frascoabierto" placeholder="Frascos Abiertos..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Dosis</label>
                            <input type="number" class="form-control"  id="dosis" name="dosis"  max="100" placeholder="Dosis..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Devolución</label>
                            <input type="number" class="form-control" id="devolucion" name="devolucion" placeholder="Devolución..."/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Expiracion</label>
                            <input type="date" class="form-control" id="expiracion" name="expiracion" placeholder="Expiración..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Lote</label>
                            <input type="text" class="form-control" id="lote" name="lote"  placeholder="Lote..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Requerimientos</label>
                            <input type="number" class="form-control" id="requerimientos" name="requerimientos"  placeholder="Requerimientos..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Observaciones</label>
                            <input type="text" class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones..."/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Archivo</label>
                            <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Archivo..."/>
                        </div>
=======
>>>>>>> d969e531ca3981503e80b21a36942b39b560c60b

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