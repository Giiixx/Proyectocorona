<?php
function confirm_password($username, $password, $conn){
    $consult = $conn->prepare('SELECT idUsuarios, UsuariosContraseña FROM usuarios WHERE UsuarioNombre=:nombre');
    $consult->bindParam(':nombre', $username);
    $consult->execute();
    $result = $consult->fetch(PDO::FETCH_ASSOC);
    //syprimir

    if(($password == $result['UsuariosContraseña'])){
        $resultado['idUsuarios'] = $result['idUsuarios'];
        $resultado['confirmacion'] = TRUE;
        return $resultado;
    } else {
        $resultado['idUsuarios'] = null;
        $resultado['confirmacion'] = FALSE;
        return $resultado;
    }
    /*
    echo $result['UsuariosContraseña'];

    if(password_verify($password, $result['UsuariosContraseña'])){
        $resultado['idUsuarios'] = $result['idUsuarios'];
        $resultado['confirmacion'] = TRUE;
        return $resultado;
    } else {
        $resultado['idUsuarios'] = null;
        $resultado['confirmacion'] = FALSE;
        return $resultado;
    }
    */
}
?>