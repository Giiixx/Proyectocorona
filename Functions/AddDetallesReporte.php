<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaDetalleReporte.php';
require_once '../entity/ListaProductos.php';
require_once '../entity/ListaUsuarioBiologico.php';
require_once '../entity/Usuario.php';

session_start();
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d");
$fecha_actual_time = date("Y-m-d H:i:s");
if(isset($_SESSION['user_id'])){
    //objetos Dettale Reporte Y Biologicos
    $agregarDetalle = new ListaDetalleReporte($conn);
    $lote = new ListaDetalleReporte($conn);
    $productos  = new ListaProductos($conn);
    $usubio = new ListaUsuariosBiologico($conn);
    //Buscar id por nombre
    $productos->SearchIdByName($conn,$_POST['DetalleBiologico']);
    $agregarDetalle->SearchReporteById($conn,$_SESSION["myuser_obj"]->getId());    
    //BUSCAR ID LOTE  POR NOMBRE
    $lote->SearhLoteByName($conn,$_POST['lote']);
    //variables para archivo
    $nombre_img=$_FILES['archivo']['name'];
    $tipo_img=$_FILES['archivo']['type'];
    $tama_img=$_FILES['archivo']['size']; 
    /*********************IDREPORTE************************ */
    if(empty($agregarDetalle->reporte)){
        $agregarDetalle->IngresarReportesUsuario($conn,"Reporte ".$_SESSION['myuser_obj']->getEstablecimiento(),$_SESSION["myuser_obj"]->getId(),$fecha_actual);    
    }
    $agregarDetalle->SearchReporteById($conn,$_SESSION["myuser_obj"]->getId());  
    $Idreporte=$agregarDetalle->reporte['idReporte'];
    /******************************************************************** */

    
    $usubio->SearchIdUsuBio($conn,$_SESSION["myuser_obj"]->getId(),$productos->producto_seleccionado['idBiologicos']);
    if(!isset($usubio->search['idUsuarioBiologico'])){
        $usubio->InsertUsuarioBiologico($conn,$_POST['stock'],$productos->producto_seleccionado['idBiologicos'],$_SESSION["myuser_obj"]->getId());
    }
    $usubio->SearchIdUsuBio($conn,$_SESSION["myuser_obj"]->getId(),$productos->producto_seleccionado['idBiologicos']);

    if(!isset($lote->lote['LotesDescripcion'])){
        $lote->IngresarLotes($conn,$_POST['lote']);
    }
    $_POST['expiracion'] = $_POST['expiracion']=="" ? "0000-00-00" : $_POST['expiracion'];

    if($agregarDetalle->IngresarDetalleReporte($conn,$_POST['stock'],
    $_POST['ingreso'],
    $_POST['ingresoextra'],
    $_POST['frascoabierto'],
    $_POST['dosis'],
    $_POST['devolucion'],
    $_POST['expiracion'],
    strtoupper($_POST['lote']),
    $_POST['requerimientos'],
    $_POST['observaciones'],
    $nombre_img,
    $fecha_actual_time,
    $usubio->search['idUsuarioBiologico'],$Idreporte)){
        $_POST['stockNuevo'] = $_POST['stockNuevo']=="" ? $_POST['stock'] : $_POST['stockNuevo'];
        $productos->UpdateStockProductoByUsuario($conn,$productos->producto_seleccionado['idBiologicos'],$_SESSION["myuser_obj"]->getId(),$_POST['stockNuevo']);
    }


    

    
    /*
    if($tama_img<=1000000){
        if($tipo_img=="image/jpeg" || $tipo_img=="image/jpg" ||$tipo_img=="image/png" ||$tipo_img=="image/gif"){
            $carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/public_html/archives/';
            move_uploaded_file( $_FILES['archivo']['tmp_name'],$carpeta_destino.$nombre_img);
        }
    }*/
    
    header('Location:../templates/datosReporte/reporteDiario.php');

}



?>      