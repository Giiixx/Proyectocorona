<?php
require '../conections/basededatos.php';
require '../entity/ListaProductos.php';
require '../entity/ListaCategoria.php';
$editarProducto = new ListaProductos($conn);
$categoria = new ListaCategoria($conn);

$categoria->BuscarCodigo($conn,$_POST['Categoria1']);

$con = strlen($_POST['codigo1']);

if($con==1){
    $codigo = "00000".$_POST['codigo1'];
}
else if($con==2){
    $codigo = "0000".$_POST['codigo1'];
}
else if($con==3){
    $codigo = "000".$_POST['codigo1'];
}
else if($con==4){
    $codigo = "00".$_POST['codigo1'];
}
else if($con==5){
    $codigo = "0".$_POST['codigo1'];
}
else $codigo = $_POST['codigo1'];

if($editarProducto->UpdateProducto($conn,
$codigo,
$_POST['nombre1'],
$_POST['proporcion1'],
$_POST['unidad1'],
$categoria->categoria_selection['idCategoria'],
$_POST['idEditarProducto'])
){
    echo "se logro";
}

header('Location:../templates/datosBiologico/registrarBiologicos.php');

?>