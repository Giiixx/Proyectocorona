<?php
require '../conections/basededatos.php';
require '../entity/ListaDetalleReporte.php';
require '../entity/ListaProductos.php';
$agregarDetalle = new ListaDetalleReporte($conn);
$productos  = new ListaProductos($conn);

$nombre_img=$_FILES['archivo']['name'];
$tipo_img=$_FILES['archivo']['type'];
$tama_img=$_FILES['archivo']['size'];
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d H:i:s");

//Buscar id por nombre
$productos->SearchIdByName($conn,$_POST['DetalleBiologico']);

if($agregarDetalle->IngresarDetalleReporte($conn,$_POST['ingreso'],
$_POST['ingresoextra'],
$_POST['frascoabierto'],
$_POST['dosis'],
$_POST['devolucion'],
$_POST['expiracion'],
$_POST['lote'],
$_POST['requerimientos'],
$_POST['observaciones'],
$nombre_img,
$fecha_actual,
$productos->producto_seleccionado['idBiologicos'],
1)
){
    echo "se logro";
}
if($tama_img<=1000000){
    if($tipo_img=="image/jpeg" || $tipo_img=="image/jpg" ||$tipo_img=="image/png" ||$tipo_img=="image/gif"){
        $carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/public_html/archives/';
        move_uploaded_file( $_FILES['archivo']['tmp_name'],$carpeta_destino.$nombre_img);
    }

}
header('Location:/public_html/templates/index.php');
?>      