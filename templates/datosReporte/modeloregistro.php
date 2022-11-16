<?php 
    require '../../conections/basededatos.php';
    require '../../entity/ListaUsuarios.php';
    require '../../entity/ListaRoles.php';

    $usuario = new ListaUsuarios($conn);
    $roles = new ListaRoles($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>data table</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <div>   
        <div class="contenedor_add">
            <button  class="ref" data-bs-toggle="modal" data-bs-target="#modalForm"><i class="fas fa-plus"></i>&nbsp&nbspAgregar Usuario</button>
        </div>    
        <!-- Modal Registrar -->
        <div class="modal fade m_1" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog m_2">
                <div class="modal-content m_3">
                    <div class="modal-header m_4">
                        <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m_4_1">
                        <form action="../Functions/AddUsuario.php.php" method="post">
                            <div class="mb-3">
                                <label class="form-label">Roles</label>
                                <select class="comboboxRegistrar" onchange="combobox()" name="Roles" id="Roles" >
                                <?php foreach($roles->roles as $valor=>$value){?>
                                    <option class="opcion">
                                    <?php echo $roles->getRolesDesc($valor) ?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" >Usuario Ris</label>
                                <input type="number" class="form-control"  id="usuario" name="usuario" placeholder="RIS..." required/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" >Establecimiento</label>
                                <input type="number" class="form-control"  id="establecimiento" name="establecimiento" placeholder="Establecimiento..." required/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" >Nombre de usuario</label>
                                <input type="number" class="form-control" id="nombre" name="nombre" placeholder="Nombre de usuario..." required/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" >Contraseña</label>
                                <input type="number" class="form-control"  id="dosis" name="dosis" placeholder="Dosis..." required/>
                            </div>
                            <div class="modal-footer d-block btn-block">
                                <button type="submit" class="btn-agregar float-end"><i class="fas fa-plus"></i>&nbsp&nbspAgregar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    <!--Tablas Usuario-->
        <div class="">
            <div class="row">
                <div class="col-12">
                    <div class="data_table">
                        <table id="example" class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>RIS</th>
                                    <th>Establecimiento</th>
                                    <th>Nombre</th>
                                    <th>Contraseña</th>
                                    <th>Rol</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                <?php foreach ($usuario->usuarios as $valor=>$value) { ?>
                    <tr>
                        <td class="fil_1_dat">
                            <?php echo $usuario->usuarios[$valor]['UsuarioRis']?>
                        </td>
                        <td class="fil_2_dat">
                            <?php echo $usuario->usuarios[$valor]['UsuariosDescEstablecimiento']?>
                        </td>
                        <td class="fil_3_dat">
                            <?php echo $usuario->usuarios[$valor]['UsuarioNombre']?>
                        </td>
                        <td class="fil_3_dat">
                            <?php echo $usuario->usuarios[$valor]['UsuariosContrasena']?>
                        </td>
                        <td class="fil_4_dat">
                            <?php  $roles->SearchNameByCod($conn,1,$usuarios->vistausuario[$valor]['idRoles']); 
                        $aux= $roles->$roles_select['RolesDesc'];
                        echo $aux?>
                        </td>
                        <td class="fil_5_dat">
                            btn
                        </td>
                    </tr>
                    <?php } ?> 
                    </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/jquery-3.6.0.min.js"></script>
        <script src="../assets/js/datatables.min.js"></script>
        <script src="../assets/js/pdfmake.min.js"></script>
        <script src="../assets/js/vfs_fonts.js"></script>
        <script src="../assets/js/custom.js"></script>
    </div>
</body>
</html>