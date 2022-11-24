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
$editarDetalle = new ListaDetalleReporte($conn);
$productos  = new ListaProductos($conn);
$usubio = new ListaUsuariosBiologico($conn);
$productos->SearchIdByName($conn,$_POST['DetalleBiologico1']);
$usubio->SearchIdLoteByName($conn,$_POST['lote1']);

//Variables Id
$idProducto=$productos->producto_seleccionado['idBiologicos'];
$idlote=$usubio->search['idLoteBiologico'];
$idUsuario=$_SESSION["myuser_obj"]->getId();

//BuscarIdUsuarioBiologico
$usubio->SearchIdUsuBio($conn,$idUsuario,$idProducto,$idlote);
//IdUsuarioBiologico
$idUsuarioBiologico=$usubio->search['idUsuarioBiologico'];
//Id DetalleReporte
$editarDetalle->SearchDetalleReporteById($conn,$_POST['idEditarDetalles']);
$resultado=(($editarDetalle->detalleReporte['ReportesStockAnterior']+$editarDetalle->detalleReporte['ReportesIngresos']+$editarDetalle->detalleReporte['ReportesIngresosExtra'])-($editarDetalle->detalleReporte['ReportesFrascosAbiertos']+$editarDetalle->detalleReporte['ReportesDevolucion']))-$_POST['stockNuevo1']; 
  //variables para archivo
$nombre_img=$_FILES['archivo1']['name'];
$tipo_img=$_FILES['archivo1']['type'];
$tama_img=$_FILES['archivo1']['size'];


if(!isset($idlote)){
    $usubio->InsertLote($conn,$_POST['lote1']);
    $usubio->SearchIdLoteByName($conn,$_POST['lote1']);

    $usubio->InsertUsuarioBiologico($conn,$_POST['stock1'],$idProducto,$idUsuario,$usubio->search['idLoteBiologico']);
    $usubio->SearchIdUsuBio($conn,$_SESSION["myuser_obj"]->getId(),$productos->producto_seleccionado['idBiologicos'],$usubio->search['idLoteBiologico']);
    
    $editarDetalle->UpdateDetalleReporte($conn,
    $_POST['stock1'],
    $_POST['ingreso1'],
    $_POST['ingresoextra1'],
    $_POST['frascoabierto1'],
    $_POST['dosis1'],
    $_POST['devolucion1'],
    $_POST['expiracion1'],
    $_POST['requerimientos1'],
    $_POST['observaciones1'],
    $_POST['archivo1'],
    $usubio->search['idUsuarioBiologico'],
    $_POST['idEditarDetalles']);


    $productos->UpdateStockProductoByUsuario($conn,$idProducto,$idUsuario,$idlote,$editarDetalle->detalleReporte['UsuarioBiologicoStock']-$resultado);
    $editarDetalle->SearchDetalleReporteById($conn,$_POST['idEditarDetalles']);     
    $editarDetalle->VistaDetalleReporteByBiologico($conn, $idUsuario,$fecha_actual,$idProducto,$idlote);
    
    foreach ($editarDetalle->vistadetallReporte as $valor => $value){
            if($_POST['idEditarDetalles']<$editarDetalle->vistadetallReporte[$valor]['idReportes']){
                echo "\n";
                echo $editarDetalle->vistadetallReporte[$valor]['ReportesStockAnterior'];
                $editarDetalle->UpdateStockAnteriorById($conn,$editarDetalle->vistadetallReporte[$valor]['idReportes'],$editarDetalle->vistadetallReporte[$valor]['ReportesStockAnterior']-$resultado);
                
            }   
    }     

}else{
    $usubio->SearchIdUsuBio($conn,$idUsuario,$idProducto,$idlote);
    if(!isset($usubio->search['idUsuarioBiologico'])){
        $usubio->InsertUsuarioBiologico($conn,$_POST['stock1'],$idProducto,$idUsuario,$idlote);
        $usubio->SearchIdUsuBio($conn,$idUsuario,$idProducto,$idlote);

        $editarDetalle->UpdateDetalleReporte($conn,
        $_POST['stock1'],
        $_POST['ingreso1'],
        $_POST['ingresoextra1'],
        $_POST['frascoabierto1'],
        $_POST['dosis1'],
        $_POST['devolucion1'],
        $_POST['expiracion1'],
        $_POST['requerimientos1'],
        $_POST['observaciones1'],
        $_POST['archivo1'],
        $usubio->search['idUsuarioBiologico'],
        $_POST['idEditarDetalles']);


        $productos->UpdateStockProductoByUsuario($conn,$idProducto,$idUsuario,$idlote,$editarDetalle->detalleReporte['UsuarioBiologicoStock']-$resultado);
        $editarDetalle->SearchDetalleReporteById($conn,$_POST['idEditarDetalles']);     
        $editarDetalle->VistaDetalleReporteByBiologico($conn, $idUsuario,$fecha_actual,$idProducto,$idlote);
        
        foreach ($editarDetalle->vistadetallReporte as $valor => $value){
                if($_POST['idEditarDetalles']<$editarDetalle->vistadetallReporte[$valor]['idReportes']){
                    echo "\n";
                    echo $editarDetalle->vistadetallReporte[$valor]['ReportesStockAnterior'];
                    $editarDetalle->UpdateStockAnteriorById($conn,$editarDetalle->vistadetallReporte[$valor]['idReportes'],$editarDetalle->vistadetallReporte[$valor]['ReportesStockAnterior']-$resultado);
                    
                }   
        }                


    }else{
        
        if($editarDetalle->UpdateDetalleReporte($conn,
        $_POST['stock1'],
        $_POST['ingreso1'],
        $_POST['ingresoextra1'],
        $_POST['frascoabierto1'],
        $_POST['dosis1'],
        $_POST['devolucion1'],
        $_POST['expiracion1'],
        $_POST['requerimientos1'],
        $_POST['observaciones1'],
        $_POST['archivo1'],
        $usubio->search['idUsuarioBiologico'],
        $_POST['idEditarDetalles'])){   
        
            $productos->UpdateStockProductoByUsuario($conn,$idProducto,$idUsuario,$idlote,$editarDetalle->detalleReporte['UsuarioBiologicoStock']-$resultado);
            $editarDetalle->SearchDetalleReporteById($conn,$_POST['idEditarDetalles']);     
            $editarDetalle->VistaDetalleReporteByBiologico($conn, $idUsuario,$fecha_actual,$idProducto,$idlote);
            
            foreach ($editarDetalle->vistadetallReporte as $valor => $value){
                    if($_POST['idEditarDetalles']<$editarDetalle->vistadetallReporte[$valor]['idReportes']){
                        echo "\n";
                        echo $editarDetalle->vistadetallReporte[$valor]['ReportesStockAnterior'];
                        $editarDetalle->UpdateStockAnteriorById($conn,$editarDetalle->vistadetallReporte[$valor]['idReportes'],$editarDetalle->vistadetallReporte[$valor]['ReportesStockAnterior']-$resultado);
                        
                    }   
            }               
            }

    }
}


}



header('Location:/public_html/templates/datosReporte/reporteDiario.php');

?>      