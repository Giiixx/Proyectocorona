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
$editarstockVista = new ListaDetalleReporte($conn);
$lote = new ListaDetalleReporte($conn);
$productos  = new ListaProductos($conn);
$usubio = new ListaUsuariosBiologico($conn);
$productos->SearchIdByName($conn,$_POST['DetalleBiologico1']);

//Variables Id
$idProducto=$productos->producto_seleccionado['idBiologicos'];
$idUsuario=$_SESSION["myuser_obj"]->getId();

//BuscarIdUsuarioBiologico
$usubio->SearchIdUsuBio($conn,$idUsuario,$idProducto);
//IdUsuarioBiologico
$idUsuarioBiologico=$usubio->search['idUsuarioBiologico'];

//Id DetalleReporte
$editarDetalle->SearchDetalleReporteById($conn,$_POST['idEditarDetalles']);
$Idreporte=$_POST['idEditarDetalles'];

//ID LOTE
$lote->SearhLoteByName($conn,$_POST['lote1']);


//Resultado de aumento o disminucion de stock
$resultado=(($editarDetalle->detalleReporte['ReportesIngresos']+$editarDetalle->detalleReporte['ReportesIngresosExtra'])-($editarDetalle->detalleReporte['ReportesFrascosAbiertos']+$editarDetalle->detalleReporte['ReportesDevolucion'])); 
  //variables para archivo
$nombre_img=$_FILES['archivo1']['name'];
$tipo_img=$_FILES['archivo1']['type'];
$tama_img=$_FILES['archivo1']['size'];

if($editarDetalle->detalleReporte['BiologicosNom']!=$_POST['DetalleBiologico1']){
    $usubio->SearchIdUsuBio($conn,$idUsuario,$idProducto);
    if(!isset($usubio->search['idUsuarioBiologico'])){
        $usubio->InsertUsuarioBiologico($conn,$_POST['stock1'],$idProducto,$idUsuario);}
    $usubio->SearchIdUsuBio($conn,$idUsuario,$idProducto);

    $productos->UpdateStockProductoByUsuario($conn,$editarDetalle->detalleReporte['idBiologicos'],$idUsuario,$editarDetalle->detalleReporte['UsuarioBiologicoStock']+$resultado);
    $editarstockVista->VistaDetalleReporteByBiologico($conn, $_SESSION["myuser_obj"]->getId(),$fecha_actual,$editarDetalle->detalleReporte['Biologicos_idBiologicos']);
    foreach ($editarstockVista->vistadetallReporte as $valor => $value){
            if($Idreporte<$editarstockVista->vistadetallReporte[$valor]['idReportes']){
                $editarstockVista->UpdateStockAnteriorById($conn,$editarstockVista->vistadetallReporte[$valor]['idReportes'],$editarstockVista->vistadetallReporte[$valor]['ReportesStockAnterior']+$resultado);
            }
    }   
    $resultadonew=($_POST['ingreso1']+$_POST['ingresoextra1'])-($_POST['frascoabierto1']+$_POST['devolucion1']);
    $productos->SearchStockName($conn,$_POST['DetalleBiologico1'],$_SESSION["myuser_obj"]->getId());
    $productos->UpdateStockProductoByUsuario($conn,$editarDetalle->detalleReporte['idBiologicos'],$idUsuario,$productos->producto_seleccionado['UsuarioBiologicoStock']+$resultadonew);
    $editarstockVista->VistaDetalleReporteByBiologico($conn, $_SESSION["myuser_obj"]->getId(),$fecha_actual,$productos->producto_seleccionado['Biologicos_idBiologicos']);
    foreach ($editarstockVista->vistadetallReporte as $valor => $value){
            if($Idreporte<$editarstockVista->vistadetallReporte[$valor]['idReportes']){
                $editarstockVista->UpdateStockAnteriorById($conn,$editarstockVista->vistadetallReporte[$valor]['idReportes'],$editarstockVista->vistadetallReporte[$valor]['ReportesStockAnterior']+$resultadonew);
            }
    }   
}else{
    $resultado=$resultado-(($_POST['ingreso1']+$_POST['ingresoextra1'])-($_POST['frascoabierto1']+$_POST['devolucion1']));
    $productos->UpdateStockProductoByUsuario($conn,$editarDetalle->detalleReporte['idBiologicos'],$idUsuario,$editarDetalle->detalleReporte['UsuarioBiologicoStock']-$resultado);
    $editarstockVista->VistaDetalleReporteByBiologico($conn, $_SESSION["myuser_obj"]->getId(),$fecha_actual,$editarDetalle->detalleReporte['Biologicos_idBiologicos']);
    
    foreach ($editarstockVista->vistadetallReporte as $valor => $value){
        echo $Idreporte."<".$editarstockVista->vistadetallReporte[$valor]['idReportes'];
            if($Idreporte<$editarstockVista->vistadetallReporte[$valor]['idReportes']){
                $editarstockVista->UpdateStockAnteriorById($conn,$editarstockVista->vistadetallReporte[$valor]['idReportes'],$editarstockVista->vistadetallReporte[$valor]['ReportesStockAnterior']-$resultado);
            }

    }


}         

if(!isset($lote->lote['LotesDescripcion'])){
    $lote->IngresarLotes($conn,$_POST['lote1']);
}

$editarDetalle->UpdateDetalleReporte($conn,
$_POST['stock1'],
$_POST['ingreso1'],
$_POST['ingresoextra1'],
$_POST['frascoabierto1'],
$_POST['dosis1'],
$_POST['devolucion1'],
$_POST['expiracion1'],
strtoupper($_POST['lote1']),
$_POST['requerimientos1'],
$_POST['observaciones1'],
$_POST['archivo1'],
$usubio->search['idUsuarioBiologico'],
$_POST['idEditarDetalles']);

}




header('Location:/public_html/templates/datosReporte/reporteDiario.php');

?>      