<?php
require_once '../../conections/basededatos.php';
require_once '../../entity/ListaProductos.php';
require_once '../../entity/ListaDetalleReporte.php';
require_once '../../entity/ListaCategoria.php';
require_once '../../entity/Usuario.php';
require_once '../../Functions/sesion/confirm_existuser.php';
require_once '../../Functions/sesion/confirm_password.php';

session_start();
isset($_SESSION['user_id']) ? null : header('Location:../../index.php');
confirm_existuser($_SESSION['user_id'], $conn) == FALSE ? header('Location:../../index.php') : null;

$productos = new ListaProductos($conn);
$categoria = new ListaCategoria($conn);
$detalleReporte = new ListaDetalleReporte($conn);
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d");
$idUsuario = $_SESSION["myuser_obj"]->getId();
$productos->init($conn);
$productos->ListaUnidad($conn);

$detalleReporte->SearchReporteById($conn, $_SESSION["myuser_obj"]->getId());

$habilitar = $detalleReporte->SearchReporteByIdBool($conn,$idUsuario) ? ($detalleReporte->reporte['ReporteApertura']>$fecha_actual ? FALSE :TRUE ) : TRUE;

?>


<?php require '../partials/headerhtml.php' ?>

<?php if (!empty($_SESSION['user_id'])) : ?>
    <title>Registrar Biologico</title>
    </head>

    <body>

        <?php require '../partials/navbar.php' ?>
        <div class="main-panel">
            <div class="contenedor_add">
                <button class="ref" data-bs-toggle="modal" data-bs-target="#modalForm"><i class="fas fa-plus"></i>&nbsp&nbspAgregar Biologico</button>
            </div>
            <!-- Modal Registrar -->
            <div class="modal fade m_1" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog m_2">
                    <div class="modal-content m_3">
                        <div class="modal-header m_4">
                            <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body m_4_1">
                            <form action="../../Functions/AddProducto.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Codigo</label>
                                    <input type="number" class="form-control" id="codigo" name="codigo" placeholder="Codigo..." required />
                                    <div id="Mensajeerror" class="validaerror"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Proporcion</label>
                                    <input type="number" class="form-control" id="proporcion" name="proporcion" placeholder="Proporcion..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Unidad</label>
                                    <select class="comboregistro" name="unidad" id="unidad">
                                        <?php foreach ($productos->unidad as $valor => $value) { ?>
                                            <option class="opcion">
                                                <?php echo $productos->unidad[$valor]['BiologicosUnidad'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Categoría</label>
                                    <select class="comboboxRegistrar" name="Categoria" id="Categoria">
                                        <?php foreach ($categoria->categoria as $valor => $value) { ?>
                                            <option class="opcion">
                                                <?php echo $categoria->getNombre($valor) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="modal-footer d-block btn-block">
                                    <button type="submit" class="btn-agregar float-end"><i class="fas fa-plus"></i>&nbsp&nbspAgregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Modal Registrar -->

            <!-- Modal Editar -->
            <div class="modal fade me_1" id="modalEditForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog m_2">
                    <div class="modal-content m_3">
                        <div class="modal-header m_4">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Biologico</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body m_4_1">
                            <form action="../../Functions/EditProducto.php" method="post">
                                <input type="hidden" id="idEditarProducto" name="idEditarProducto">
                                <div class="mb-3">
                                    <label class="form-label">Codigo</label>
                                    <input type="number" class="form-control" id="codigo1" name="codigo1" placeholder="Ingrese un Codigo..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre1" name="nombre1" placeholder="Ingrese un Nombre..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Proporcion</label>
                                    <input type="number" class="form-control" id="proporcion1" name="proporcion1" placeholder="Ingrese un Proporcion..." required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Unidad</label>
                                    <select class="comboregistro" name="unidad1" id="unidad1">
                                        <?php foreach ($productos->unidad as $valor => $value) { ?>
                                            <option class="opcion">
                                                <?php echo $productos->unidad[$valor]['BiologicosUnidad'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Categoría</label>
                                    <select class="comboboxRegistrar" name="Categoria1" id="Categoria1">
                                        <?php foreach ($categoria->categoria as $valor => $value) { ?>
                                            <option class="opcion">
                                                <?php echo $categoria->getNombre($valor) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="modal-footer d-block btn-block">
                                    <button type="submit" class=""><i class="fas fa-plus"></i>&nbsp&nbspEditar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Modal Editar -->



            <!--Listar Datos de Biologicos -->
            <div>
                <table id="example" class="datosreporte">
                    <thead>
                        <tr class="fil_1">
                            <th>CODIGO</th>
                            <th>NOMBRE</th>
                            <th>PROPORCION</th>
                            <th>UNIDAD</th>
                            <th>CATEGORIA</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos->productos as $valor => $value) { ?>
                            <tr>
                                <td class="fil_1_dat">
                                    <?php echo $productos->productos[$valor]['BiologicosCod'] ?>
                                </td>
                                <td class="fil_2_dat">
                                    <?php echo $productos->productos[$valor]['BiologicosNom'] ?>
                                </td>
                                <td class="fil_3_dat">
                                    <?php echo $productos->productos[$valor]['BiologicosProporcion'] ?>
                                </td>
                                <td class="fil_4_dat">
                                    <?php echo $productos->productos[$valor]['BiologicosUnidad'] ?>
                                </td>


                                <td class="fil_5_dat">

                                    <?php
                                    $pro = $productos->productos[$valor]['Categoria_idCategoria'];
                                    $categoria->Buscarnombre($conn, $pro);
                                    $aux = $categoria->categoria_selection['CategoriaDesc'];
                                    echo $aux
                                    ?>

                                </td>

                                <td class="fil_18_dat">
                                    <?php
                                    if ($fecha_actual == $productos->productos[$valor]['BiologicosFecha']) { ?>
                                        <a href="" id="<?= $productos->productos[$valor]['idBiologicos'] ?>" param1="<?= $productos->productos[$valor]['BiologicosCod'] ?>" param2="<?= $productos->productos[$valor]['BiologicosNom'] ?>" param3="<?= $productos->productos[$valor]['BiologicosProporcion'] ?>" param4="<?= $productos->productos[$valor]['BiologicosUnidad'] ?>" class="editarproductoss" data-bs-toggle="modal" data-bs-target="#modalEditForm"><img src="../assets/bootstrap-icons-1.10.1/pen-fill.svg"></a>
                                        <a class="btneliminar" href="../../Functions/DeleteProducto.php?id=<?= $productos->productos[$valor]['idBiologicos'] ?>" onclick="return confirm('DESEA ELIMINAR?')"><img src="../assets/bootstrap-icons-1.10.1/trash.svg"></a>
                                    <?php } ?>
                                </td>

                            </tr>
                        <?php } ?>


                    </tbody>
                </table>
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
        <script src="../assets/js/EditarProducto.js"></script>



    <?php endif; ?>
    </body>

    </html>