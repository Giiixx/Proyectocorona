<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaProductos.php';
require_once '../entity/ListaUsuarioBiologico.php';
require_once '../Functions/sesion/confirm_existuser.php';
require_once '../entity/Usuario.php';

session_start();
isset($_SESSION['user_id']) ? null : header('Location: /public_html/templates/index.php');
confirm_existuser($_SESSION['user_id'], $conn) == FALSE ? header('Location: /public_html/templates/index.php') : null;


if(isset($_SESSION['user_id'])){
    $productos  = new ListaProductos($conn);
    $UsuarioBiologico = new ListaUsuariosBiologico($conn);

    $UsuarioBiologico->SearchStockByNameBiologico($conn,$_POST['aux'], $_SESSION["myuser_obj"]->getId());

    echo json_encode($UsuarioBiologico->lotesBiologico);
}
?>