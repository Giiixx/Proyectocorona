<?php 
    require '../../conections/basededatos.php';
    require '../../entity/ListaProductos.php';
    require '../../entity/ListaCategoria.php';

    $productos = new ListaProductos($conn);
    $categoria = new ListaCategoria($conn);
    $productos ->init($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Agregar Producto</title>
</head>
<body>
<div>
    <div class="contenedor_add">
        <button  class="ref" data-bs-toggle="modal" data-bs-target="#modalForm"><i class="fas fa-plus"></i>&nbsp&nbspAgregar Biologico</button>
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
                            <label class="form-label" >Codigo</label>
                            <input type="number" class="form-control"  id="codigo" name="codigo" placeholder="Codigo..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Nombre</label>
                            <input type="text" class="form-control"  id="nombre" name="nombre" placeholder="Nombre..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Proporcion</label>
                            <input type="number" class="form-control" id="proporcion" name="proporcion" placeholder="Proporcion..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Unidad</label>
                            <input type="text" class="form-control"  id="unidad" name="unidad" placeholder="Unidad..." required/>
                        </div>
                        <div class="mb-3">
                        <label class="form-label">Categoría</label>
                            <select class="comboboxRegistrar" name="Categoria" id="Categoria">
                                <?php foreach($categoria->categoria as $valor=>$value){?>
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
                    <form action="../Functions/EditProducto.php" method="post">
                        <input type="hidden" id="idEditarProducto" name="idEditarProducto">
                        <div class="mb-3">
                            <label class="form-label">Codigo</label>
                            <input type="number" class="form-control"  id="codigo1" name="codigo1" placeholder="Codigo..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Nombre</label>
                            <input type="text" class="form-control"  id="nombre1" name="nombre1" placeholder="Nombre..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Proporcion</label>
                            <input type="number" class="form-control" id="proporcion1" name="proporcion1" placeholder="Proporcion..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" >Unidad</label>
                            <input type="text" class="form-control"  id="unidad1" name="unidad1" placeholder="Unidad..." required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Categoría</label>
                            <select class="comboboxRegistrar" name="Categoria1" id="Categoria1">
                                <?php foreach($categoria->categoria as $valor=>$value){?>
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
        <table id="example" class="datosreporte" >
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
            <?php foreach ($productos->productos as $valor=>$value) { ?>
                <tr>
                    <td class="fil_1_dat">
                        <?php echo $productos->productos[$valor]['BiologicosCod']?>
                    </td>
                    <td class="fil_2_dat">
                        <?php echo $productos->productos[$valor]['BiologicosNom']?>
                    </td>
                    <td class="fil_3_dat">
                        <?php echo $productos->productos[$valor]['BiologicosProporcion']?>
                    </td>
                    <td class="fil_4_dat">
                        <?php echo $productos->productos[$valor]['BiologicosUnidad']?>
                    </td>

                    <td class="fil_5_dat">
                    
                        <?php 
                            $pro=$productos->productos[$valor]['Categoria_idCategoria'];
                            $categoria->Buscarnombre($conn,$pro);
                            $aux=$categoria->categoria_selection['CategoriaDesc'];
                            echo $aux
                        ?>
                    
                    </td>
                    <td class="fil_18_dat">
                        <a href="" 
                        id="<?= $productos->productos[$valor]['idBiologicos']?>"
                        param1="<?= $productos->productos[$valor]['BiologicosCod']?>"
                        param2="<?= $productos->productos[$valor]['BiologicosNom']?>"
                        param3="<?= $productos->productos[$valor]['BiologicosProporcion']?>"
                        param4="<?= $productos->productos[$valor]['BiologicosUnidad']?>"
                        class="editarproductoss"
                        data-bs-toggle="modal" data-bs-target="#modalEditForm"><img src="../assets/bootstrap-icons-1.10.1/pen-fill.svg"></a>
                        <a class="btneliminar" href="../../Functions/DeleteProducto.php?id=<?=$productos->productos[$valor]['idBiologicos'] ?>"  onclick="return confirm('DESEA ELIMINAR?')"><img src="../assets/bootstrap-icons-1.10.1/trash.svg"></a>
                    </td>
                </tr>
            <?php } ?> 
            <script src="../assets/js/bootstrap.bundle.min.js"></script>
            <script src="../assets/js/scripts.js"></script>
            <script src="../assets/js/jquery.js"></script>
            <script src="../assets/js/EditarProductos.js"></script>
            
            

            </tbody>
        </table>
    </div>
</div>
    
</body>
</html>
