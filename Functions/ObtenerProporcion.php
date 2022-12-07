<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaProductos.php';
require_once '../entity/ListaUsuarioBiologico.php';
require_once '../Functions/sesion/confirm_existuser.php';
require_once '../entity/Usuario.php';

session_start();

if(isset($_SESSION['user_id'])){
    $ProporcionBiologico  = new ListaProductos($conn);

    $ProporcionBiologico->SearchProporcionById($conn,$_POST['proporcion']);

    echo $ProporcionBiologico->producto_seleccionado['BiologicosProporcion'];

}
?>