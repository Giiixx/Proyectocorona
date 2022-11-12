<?php
require '../conections/basededatos.php';
require '../entity/ListaDetalleReporte.php';
require '../entity/ListaProductos.php';
$agregarDetalle = new ListaDetalleReporte($conn);
$productos  = new ListaProductos($conn);

//Buscar id por nombre
$productos->SearchIdByName($conn,$_POST['DetalleBiologico']);


date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d H:i:s");


if($agregarDetalle->IngresarDetalleReporte($conn,$_POST['ingreso'],
$_POST['ingresoextra'],
$_POST['frascoabierto'],
$_POST['dosis'],
$_POST['devolucion'],
$_POST['expiracion'],
$_POST['lote'],
$_POST['requerimientos'],
$_POST['observaciones'],
$_POST['archivo'],
$fecha_actual,
$productos->producto_seleccionado['idBiologicos'],
1)
){
    echo "se logro";
}

header('Location:/public_html/templates/index.php');
?>      