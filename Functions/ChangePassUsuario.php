<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaDetalleReporte.php';
require_once '../entity/Usuario.php';

session_start();
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d");
$hora = date("H:i:s");
if(isset($_SESSION['user_id'])){
    //objetos Dettale Reporte Y Biologicos
    $cambiar = new ListaDetalleReporte($conn);

    $password = password_hash($_POST['contra'], PASSWORD_BCRYPT);
    $aux = $cambiar->UpdateContraseña($conn,$_POST['establecimiento'],$password);
    echo $aux;

}



?>      