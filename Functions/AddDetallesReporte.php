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
    $imagenes = new ListaDetalleReporte($conn); 
    $productos  = new ListaProductos($conn);
    $usubio = new ListaUsuariosBiologico($conn);
    //Buscar id por nombre
    $productos->SearchIdByName($conn,$_POST['DetalleBiologico']);
    $agregarDetalle->SearchReporteById($conn,$_SESSION["myuser_obj"]->getId());    
    //BUSCAR ID LOTE  POR NOMBRE
    $lote->SearhLoteByName($conn,$_POST['lote']);
    

    /**********************************************************************REPORTES*****************************************************************************/  
    if(empty($agregarDetalle->reporte)){
        $agregarDetalle->IngresarReportesUsuario($conn,"Reporte ".$_SESSION['myuser_obj']->getEstablecimiento(),$_SESSION["myuser_obj"]->getId(),$fecha_actual);    
    }
    $agregarDetalle->SearchReporteById($conn,$_SESSION["myuser_obj"]->getId());  
    $Idreporte=$agregarDetalle->reporte['idReporte'];
    /****************************************************************************************************************************************************************** */
    $usubio->SearchIdUsuBio($conn,$_SESSION["myuser_obj"]->getId(),$productos->producto_seleccionado['idBiologicos']);
    if(!isset($usubio->search['idUsuarioBiologico'])){
        $usubio->InsertUsuarioBiologico($conn,$_POST['stock'],$productos->producto_seleccionado['idBiologicos'],$_SESSION["myuser_obj"]->getId());
    }
    $usubio->SearchIdUsuBio($conn,$_SESSION["myuser_obj"]->getId(),$productos->producto_seleccionado['idBiologicos']);


    /***********************************************************************ARCHIVOS************************************************************************/
    $nombre_img=$_FILES['archivo']['name'];
    $tipo_img=$_FILES['archivo']['type'];
    $tama_img=$_FILES['archivo']['size']; 
    //variables para archivo
    $imagenes->ListaArchivos($conn,$agregarDetalle->reporte['idReporte'],$usubio->search['idUsuarioBiologico'],$fecha_actual);

    $carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/public_html/archives/'.$_SESSION["myuser_obj"]->getId().'/'.$fecha_actual.'/'.$productos->producto_seleccionado['BiologicosCod'].'/';
    if(!file_exists($carpeta_destino)){
        mkdir($carpeta_destino,0777,true);
    }
    if($nombre_img!=""){
        for($i=strlen($nombre_img)-1;$i>=0;$i--){
            if($nombre_img[$i]=='.'){
                $hasta=$i;
                break;
            }
        }
        $confirmar=TRUE;
    
        foreach($imagenes->lista as $valor=>$value){
            echo substr($imagenes->lista[$valor]['ReportesArchivo'],0,$hasta+3);
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
    move_uploaded_file( $_FILES['archivo']['tmp_name'],$carpeta_destino.$nombre_img);
    

    if(!isset($lote->lote['LotesDescripcion'])){
        $lote->IngresarLotes($conn,strtoupper($_POST['lote']));
    }
    $_POST['expiracion'] = $_POST['expiracion']=="" ? "0000-00-00" : $_POST['expiracion'];

    if($agregarDetalle->IngresarDetalleReporte($conn,$_POST['stock'],
    $_POST['ingreso'],
    $_POST['ingresoextra'],
    $_POST['frascoabierto'],
    $_POST['dosis'],
    $_POST['devolucion'],   
    $_POST['expiracion'],
    $_POST['lote'] !="" ? strtoupper($_POST['lote']):null,
    $_POST['requerimientos'],
    $_POST['observaciones'],
    $nombre_img,
    $fecha_actual_time,
    'D',
    $usubio->search['idUsuarioBiologico'],$Idreporte)){
        $_POST['stockNuevo'] = $_POST['stockNuevo']=="" ? $_POST['stock'] : $_POST['stockNuevo'];
        $productos->UpdateStockProductoByUsuario($conn,$productos->producto_seleccionado['idBiologicos'],$_SESSION["myuser_obj"]->getId(),$_POST['stockNuevo']);
    }


    
    header('Location:../templates/datosReporte/reporteDiario.php');

}
