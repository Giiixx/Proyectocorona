<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaDetalleReporte.php';
require_once '../entity/ListaProductos.php';
require_once '../entity/ListaUsuarioBiologico.php';
require_once '../entity/Usuario.php';

session_start();
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d");
if(isset($_SESSION['user_id'])){
    $borrarDetalle = new ListaDetalleReporte($conn);
    $EditarStockAnteriorDetalle = new ListaDetalleReporte($conn);
    $productos  = new ListaProductos($conn);
    $elim_id = $_GET['id'];
    $borrarDetalle->SearchDetalleReporteById($conn, $elim_id);
    $ingresoSuma=$borrarDetalle->detalleReporte['ReportesIngresos']+$borrarDetalle->detalleReporte['ReportesIngresosExtra'];
    $salidasSuma=$borrarDetalle->detalleReporte['ReportesFrascosAbiertos']+$borrarDetalle->detalleReporte['ReportesDevolucion'];
    $update=(int) ($borrarDetalle->detalleReporte['UsuarioBiologicoStock'])+$salidasSuma-$ingresoSuma;
    
    
    
    if($productos->UpdateStockProductoByUsuario($conn,$borrarDetalle->detalleReporte['idBiologicos'],$_SESSION["myuser_obj"]->getId(),$update)){
        $borrarDetalle->DeleteDetallleReporte($conn,$elim_id);
        $EditarStockAnteriorDetalle->VistaDetalleReporteByBiologico($conn, $_SESSION["myuser_obj"]->getId(),$fecha_actual,$borrarDetalle->detalleReporte['Biologicos_idBiologicos']);
        foreach ($EditarStockAnteriorDetalle->vistadetallReporte as $valor => $value){
                if($elim_id<$EditarStockAnteriorDetalle->vistadetallReporte[$valor]['idReportes']){
                    $EditarStockAnteriorDetalle->UpdateStockAnteriorById($conn,$EditarStockAnteriorDetalle->vistadetallReporte[$valor]['idReportes'],$EditarStockAnteriorDetalle->vistadetallReporte[$valor]['ReportesStockAnterior']+($salidasSuma-$ingresoSuma));
                }
        }               
    }
        
    header('Location:/public_html/templates/datosReporte/reporteDiario.php');

}
?>      