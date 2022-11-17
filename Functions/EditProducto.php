<?php
require '../conections/basededatos.php';
require '../entity/ListaProductos.php';
require '../entity/ListaCategoria.php';
$editarProducto = new ListaProductos($conn);
$categoria = new ListaCategoria($conn);

$categoria->BuscarCodigo($conn,$_POST['Categoria1']);

if($editarProducto->UpdateProducto($conn,
$_POST['codigo1'],
$_POST['nombre1'],
$_POST['proporcion1'],
$_POST['unidad1'],
$categoria->categoria_selection['idCategoria'],
$_POST['idEditarProducto'])
){
    echo "se logro";
}

header('Location:/public_html/templates/datosReporte/productoadd.php');

?>