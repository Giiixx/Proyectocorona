<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaDetalleReporte.php';
require_once '../entity/ListaProductos.php';
require_once '../entity/ListaUsuarioBiologico.php';
require_once '../entity/Usuario.php';

session_start();
date_default_timezone_set("America/Bogota");


if(isset($_SESSION['user_id'])){
$editarDetalle = new ListaDetalleReporte($conn);
$editarstockVista = new ListaDetalleReporte($conn);
$lote = new ListaDetalleReporte($conn);
$imagenes = new ListaDetalleReporte($conn);
$productos  = new ListaProductos($conn);
$usubio = new ListaUsuariosBiologico($conn);

//Variables Id
$idProducto=$_POST['idBiologicos'];
$idUsuario=$_SESSION["myuser_obj"]->getId();

//BuscarIdUsuarioBiologico
$usubio->SearchIdUsuBio($conn,$idUsuario,$idProducto);
//IdUsuarioBiologico
$idUsuarioBiologico=$usubio->search['idUsuarioBiologico'];
//Id Reporte
$editarDetalle->SearchReporteById($conn,$_SESSION["myuser_obj"]->getId());
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
//fecha de archivos
$fecha_actual = $editarDetalle->detalleReporte['fecha'];

$imagenes->ListaArchivos($conn,$editarDetalle->reporte['idReporte'],$usubio->search['idUsuarioBiologico'],$fecha_actual);

$carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/public_html/archives/'.$_SESSION["myuser_obj"]->getId().'/'.$fecha_actual.'/'.$editarDetalle->detalleReporte['BiologicosCod'].'/';
if(!file_exists($carpeta_destino)){
    mkdir($carpeta_destino,0777,true);
}
if($nombre_img==""){
    $nombre_img=$editarDetalle->detalleReporte['ReportesArchivo'];
}else{
    unlink('../archives/'.$_SESSION["myuser_obj"]->getId().'/'.$fecha_actual.'/'.$productos->producto_seleccionado['BiologicosCod'].'/'.$editarDetalle->detalleReporte['ReportesArchivo']);    
    for($i=strlen($nombre_img)-1;$i>=0;$i--){
        if($nombre_img[$i]=='.'){
            $hasta=$i;
            break;
        }
    }
    $confirmar=TRUE;
    
    foreach($imagenes->lista as $valor=>$value){
        if(substr($imagenes->lista[$valor]['ReportesArchivo'],0,$hasta+2) == substr($nombre_img,0,$hasta).' ('){
            for($i=0;$i<strlen($imagenes->lista[$valor]['ReportesArchivo']);$i++){
                if($imagenes->lista[$valor]['ReportesArchivo'][$i]=='('){
                    $imagenes->lista[$valor]['ReportesArchivo'][$i+1]=(int)($imagenes->lista[$valor]['ReportesArchivo'][$i+1])+1;
                    $nombre_img=$imagenes->lista[$valor]['ReportesArchivo'];
                    break;
                }
            }
            $confirmar=FALSE;
        }
    }
    if($confirmar){
        foreach($imagenes->lista as $valor=>$value){
            if($imagenes->lista[$valor]['ReportesArchivo'] == $nombre_img){
                $nombre_img=substr($nombre_img,0,$hasta).' (1).'.pathinfo($nombre_img, PATHINFO_EXTENSION);
                break; 
    
            }  
        }
    }   
}   



//unlink('../archives/'.$_SESSION["myuser_obj"]->getId().'/'.$fecha_actual.'/'.$productos->producto_seleccionado['BiologicosCod'].'/'.$nombre_img);
move_uploaded_file( $_FILES['archivo1']['tmp_name'],$carpeta_destino.$nombre_img);


$resultado=$resultado-(($_POST['ingreso1']+$_POST['ingresoextra1'])-($_POST['frascoabierto1']+$_POST['devolucion1']));
$productos->UpdateStockProductoByUsuario($conn,$editarDetalle->detalleReporte['idBiologicos'],$idUsuario,$editarDetalle->detalleReporte['UsuarioBiologicoStock']-$resultado);
$editarstockVista->VistaDetalleReporteByBiologico($conn, $_SESSION["myuser_obj"]->getId(),$editarDetalle->detalleReporte['Biologicos_idBiologicos']);

foreach ($editarstockVista->vistadetallReporte as $valor => $value){
        if($Idreporte<$editarstockVista->vistadetallReporte[$valor]['idReportes']){
            $editarstockVista->UpdateStockAnteriorById($conn,$editarstockVista->vistadetallReporte[$valor]['idReportes'],$editarstockVista->vistadetallReporte[$valor]['ReportesStockAnterior']-$resultado);
        }

}

if(!isset($lote->lote['LotesDescripcion'])){
    $lote->IngresarLotes($conn,$_POST['lote1']);
}
$_POST['expiracion1'] = $_POST['expiracion1']=="" ? "0000-00-00" : $_POST['expiracion1'];
/***********************************************************************************************************************************************/



$editarDetalle->UpdateDetalleReporte($conn,
$_POST['stock1'],
$_POST['ingreso1'],
$_POST['ingresoextra1'],
$_POST['frascoabierto1'],
$_POST['dosis1'],
$_POST['devolucion1'],
$_POST['expiracion1'],
$_POST['lote'] !="" ? strtoupper($_POST['lote1']):null,
$_POST['requerimientos1'],
$_POST['observaciones1'],
$nombre_img,
'D',
$usubio->search['idUsuarioBiologico'],
$_POST['idEditarDetalles']);
}

$_POST['pagina']==1 ? header('Location:../templates/datosReporte/reporteDiario.php') : ($_POST['pagina']==2 ? header('Location:../templates/datosReporte/editarReporteDiario.php') : header('Location:../templates/datosReporte/editarReporteHabilitado.php')) ;


?>      