<?php
function confirm_password($username, $password, $conn){
    $consult = $conn->prepare('SELECT idEstablecimiento, UsuariosPassword FROM usuarios WHERE UsuarioNombre=:nombre');
    $consult->bindParam(':nombre', $username);
    $consult->execute();
    $result = $consult->fetch(PDO::FETCH_ASSOC);
    //syprimir
/*
    if(($password == $result['UsuariosPassword'])){
        $resultado['idUsuarios'] = $result['idEstablecimiento'];
        $resultado['confirmacion'] = TRUE;
        return $resultado;
    } else {
        $resultado['idUsuarios'] = null;
        $resultado['confirmacion'] = FALSE;
        return $resultado;
    }
    */

    if(password_verify($password, $result['UsuariosPassword'])){
        $resultado['idUsuarios'] = $result['idEstablecimiento'];
        $resultado['confirmacion'] = TRUE;
        return $resultado;
    } else {
        $resultado['idUsuarios'] = null;
        $resultado['confirmacion'] = FALSE;
        return $resultado;
    }
    
}
?>