<?php
/***
	require_once 'conections/basededatos.php';
    require_once 'entity/ListaDetalleReporte.php';
    require_once 'entity/Usuario.php';
    require_once 'Functions/sesion/confirm_existuser.php';
    require_once 'Functions/sesion/confirm_password.php';


    $lista = new ListaDetalleReporte($conn);
    $lista->CONTRASEÑAS($conn);

    foreach ($lista->lista as $valor => $value){
        $sql = "UPDATE usuarios SET  UsuariosPassword = :contra where idEstablecimiento=:id" ;
        $stmt = $conn->prepare($sql);
        $password = password_hash($lista->lista[$valor]['UsuariosPassword'], PASSWORD_BCRYPT);
        $stmt->bindParam(':contra', $password);
        $stmt->bindParam(':id',$lista->lista[$valor]['idEstablecimiento']);
        $stmt->execute();
    }

     */

?>
