<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaDetalleReporte.php';
require_once '../entity/ListaProductos.php';
require_once '../entity/ListaUsuarioBiologico.php';
require_once '../entity/Usuario.php';

session_start();
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d H:i:s");
if(isset($_SESSION['user_id'])){
$editarDetalle = new ListaDetalleReporte($conn);
$productos  = new ListaProductos($conn);

//Buscar id por nombre
$productos->SearchIdByName($conn,$_POST['DetalleBiologico1']);

if($editarDetalle->UpdateDetalleReporte($conn,
$_POST['stock'],
$_POST['ingreso1'],
$_POST['ingresoextra1'],
$_POST['frascoabierto1'],
$_POST['dosis1'],
$_POST['devolucion1'],
$_POST['expiracion1'],
$_POST['requerimientos1'],
$_POST['observaciones1'],
$_POST['archivo1'],
$productos->producto_seleccionado['idBiologicos'],
$_POST['idEditarDetalles'])
){
    echo "se logro";
}

}
header('Location:/public_html/templates/index.php');

?>      