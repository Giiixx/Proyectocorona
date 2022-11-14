<?php
require '../conections/basededatos.php';
require '../entity/ListaDetalleReporte.php';
require '../entity/ListaProductos.php';
$editarDetalle = new ListaDetalleReporte($conn);
$productos  = new ListaProductos($conn);

//Buscar id por nombre
$productos->SearchIdByName($conn,$_POST['DetalleBiologico1']);

if($editarDetalle->UpdateDetalleReporte($conn,
$_POST['ingreso1'],
$_POST['ingresoextra1'],
$_POST['frascoabierto1'],
$_POST['dosis1'],
$_POST['devolucion1'],
$_POST['expiracion1'],
$_POST['lote1'],
$_POST['requerimientos1'],
$_POST['observaciones1'],
$_POST['archivo1'],
$productos->producto_seleccionado['idBiologicos'],
$_POST['idEditarDetalles'])
){
    echo "se logro";
}


header('Location:/public_html/templates/index.php');

?>      