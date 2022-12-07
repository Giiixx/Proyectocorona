<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaDetalleReporte.php';
require_once '../entity/ListaUsuarioBiologico.php';
require_once '../Functions/sesion/confirm_existuser.php';
require_once '../entity/Usuario.php';

session_start();

if(isset($_SESSION['user_id'])){
    $habilitado  = new ListaDetalleReporte($conn);
    if($habilitado->UpdateEstadoEditar($conn,$_POST['estado'],$_POST['id'])){
        echo "se logro";
    }
}
?>