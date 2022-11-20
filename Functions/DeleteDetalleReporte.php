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
    $borrarDetalle = new ListaDetalleReporte($conn);
    $productos  = new ListaProductos($conn);
    $elim_id = $_GET['id'];
    $borrarDetalle->SearchDetalleReporteById($conn, $elim_id);
    $ingresoSuma=$borrarDetalle->detalleReporte['ReportesIngresos']+$borrarDetalle->detalleReporte['ReportesIngresosExtra'];
    $salidasSuma=$borrarDetalle->detalleReporte['ReportesFrascosAbiertos']+$borrarDetalle->detalleReporte['ReportesDevolucion'];
    $update=$borrarDetalle->detalleReporte['UsuarioBiologicoStock']+$salidasSuma-$ingresoSuma;
    
    echo $borrarDetalle->detalleReporte['UsuarioBiologicoStock'];
    
    if($productos->UpdateStockProductoByUsuario($conn,$borrarDetalle->detalleReporte['idBiologicos'],$_SESSION["myuser_obj"]->getId(),$borrarDetalle->detalleReporte['idLoteBiologico'],$update)){
        $borrarDetalle->DeleteDetallleReporte($conn,$elim_id);
    }

    header('Location:/public_html/templates/datosReporte/reporteDiario.php');

}
?>      