<?php 
    require '../conections/basededatos.php';
    require '../entity/ListaProductos.php';
    require '../entity/ListaCategoria.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
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
                    <form action="../Functions/AddProducto.php" method="post">
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
                    <td>btn</td>
                </tr>
            <?php } ?> 
            

            </tbody>
        </table>
    </div>
</div>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/jquery-3.6.0.min.js"></script>

</body>
</html>