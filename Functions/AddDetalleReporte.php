<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaDetalleReporte.php';
require_once '../entity/ListaProductos.php';
require_once '../entity/Usuario.php';

session_start();
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d H:i:s");
if(isset($_SESSION['user_id'])){
    //objetos Dettale Reporte Y Biologicos
    $agregarDetalle = new ListaDetalleReporte($conn);
    $productos  = new ListaProductos($conn);
    //Buscar id por nombre
    $productos->SearchIdByName($conn,$_POST['DetalleBiologico']);
    //variables para archivo
    $nombre_img=$_FILES['archivo']['name'];
    $tipo_img=$_FILES['archivo']['type'];
    $tama_img=$_FILES['archivo']['size'];


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
    $_SESSION["myuser_obj"]->getId())
    ){
        echo "se logro";
    }
    if($tama_img<=1000000){
        if($tipo_img=="image/jpeg" || $tipo_img=="image/jpg" ||$tipo_img=="image/png" ||$tipo_img=="image/gif"){
            $carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/public_html/archives/';
            move_uploaded_file( $_FILES['archivo']['tmp_name'],$carpeta_destino.$nombre_img);
        }
    }

}



//header('Location:/public_html/templates/index.php');
?>      