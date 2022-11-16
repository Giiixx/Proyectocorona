<?php
    require '../conections/basededatos.php';
    require '../entity/ListaUsuarios.php';
    require '../entity/ListaRoles.php';
    $roles = new ListaRoles($conn)
    $agregarUsuario = new ListaUsuarios($conn);

    // Buscar id por nombre
    $roles->SearchIdByName($conn,$_POST['ListaRoles']);

    if($agregarUsuario->IngresarUsuario($conn,$_POST['UsuarioRis'],
    $_POST['UsuariosDescEstablecimiento'],
    $_POST['UsuarioNombre'],
    $_POST['UsuarioContrasena'],
    $roles->roles_selection['idRoles'],
    1)
    ){
        echo 'se logro';
    }
   header('Location:/public_html/templates/modeloregistro.php');
?>