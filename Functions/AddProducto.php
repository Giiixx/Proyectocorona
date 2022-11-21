<?php
require '../conections/basededatos.php';
require '../entity/ListaProductos.php';
require '../entity/ListaCategoria.php';

$agregarProducto = new ListaProductos($conn);
$categoria  = new ListaCategoria($conn);

date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d");
//Buscar id por nombre
$categoria->BuscarCodigo($conn,$_POST['Categoria']);

$con = strlen($_POST['codigo']);

if($con==1){
    $codigo = "00000".$_POST['codigo'];
}
else if($con==2){
    $codigo = "0000".$_POST['codigo'];
}
else if($con==3){
    $codigo = "000".$_POST['codigo'];
}
else if($con==4){
    $codigo = "00".$_POST['codigo'];
}
else if($con==5){
    $codigo = "0".$_POST['codigo'];
}
else $codigo = $_POST['codigo'];


if($agregarProducto->IngresarProducto($conn,$codigo,
strtoupper($_POST['nombre']),
$_POST['proporcion'],
$_POST['unidad'],
$fecha_actual,
$categoria->categoria_selection['idCategoria'])
){
    echo "se logro";
}

header('Location:/public_html/templates/datosReporte/productoadd.php');
?>      