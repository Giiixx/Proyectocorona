<?php
require_once '../../conections/basededatos.php';
require_once '../../entity/ListaAnuncio.php';
require_once '../../entity/Usuario.php';
require_once '../../Functions/sesion/confirm_existuser.php';
require_once '../../Functions/sesion/confirm_password.php';

session_start();
isset($_SESSION['user_id']) ? null : header('Location: ../../index.php');
confirm_existuser($_SESSION['user_id'], $conn) == FALSE ? header('Location:../../index.php') : null;


$anuncio = new ListaAnuncio($conn);

?>


<?php require '../partials/headerhtml.php' ?>

<?php if (!empty($_SESSION['user_id'])) : ?>
    <link rel="stylesheet" href="../assets/css/anuncio.css">
    <title>Editar</title>
    </head>

    <body>

        <?php require '../partials/navbar.php' ?>
            <div class="main-panel">
                <div class="anuncioedit">
                    <div class="tituloeditar">
                        <form action="../../Functions/editanuncio.php" method="post">
                            <div class="cajatitulo" >
                                <h1>Modificar Titulo</h1>
                                <textarea id="default" name="titulo" ><?php echo $anuncio->anuncio[0]['AnuncioTitulo']?></textarea>
                            </div>
                        <div class="contenido">  
                            <div class="cajaImgen">
                              <input type="file" class="form-control" id="archivo" >
                            </div>
                            <div class="cajaDescripcion">
                                <h1>Modificar Descripcion</h1>
                                <textarea id="default" name="mensaje" ><?php echo $anuncio->anuncio[0]['AnuncioMensaje']?></textarea>
                            </div>
                            
                        </div>
                        <div class="boton-editanuncio">
                            <button type="submit" class="modificar" href="#">Modificar Anuncio</button>
                        </div>
                        </form>
                    </div>
                 
                    <div class="imagenmostrar">
                        
                    </div>
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
                <!-- Main Quill library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.3.0/tinymce.min.js" referrerpolicy="origin"></script>

        <!-- Core build with no theme, formatting, non-essential modules -->
        <script src="../assets/js/texteditor.js"></script>
        <?php endif; ?>
    </body>

    </html>