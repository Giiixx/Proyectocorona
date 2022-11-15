<?php
require '../conections/basededatos.php';
require '../entity/ListaProductos.php';
require '../entity/ListaCategoria.php';
$agregarProducto = new ListaProductos($conn);
$categoria  = new ListaCategoria($conn);

//Buscar id por nombre
$categoria->BuscarCodigo($conn,$_POST['Categoria']);


if($agregarProducto->IngresarProducto($conn,$_POST['codigo'],
$_POST['nombre'],
$_POST['proporcion'],
$_POST['unidad'],
$categoria->categoria_selection['idCategoria'])
){
    echo "se logro";
}

header('Location:/public_html/templates/AddProducto.php');
?>      