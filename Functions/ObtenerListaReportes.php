<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaDetalleReporte.php';
require_once '../Functions/sesion/confirm_existuser.php';
require_once '../entity/Usuario.php';

session_start();
isset($_SESSION['user_id']) ? null : header('Location: ../templates/index.php');
confirm_existuser($_SESSION['user_id'], $conn) == FALSE ? header('Location: ../templates/index.php') : null;


if(isset($_SESSION['user_id'])){
    $lista  = new ListaDetalleReporte($conn);
    $lista->SearchIdUsuarioByName($conn,$_POST['nombre']);
    $idUsuario =$lista->lista['idEstablecimiento'];
   
    $arrayfechas[]="";  


    if(isset($_POST['fecha'])){
        $lista->SearchIdReporteByFechaCierreAndIdestablecimiento($conn, $idUsuario,$_POST['fecha']);
    }else{
        $lista->SearchFechasCierreOfEstablecimientos($conn,$idUsuario);
        foreach($lista->lista as $valor=>$value){
            $arrayfechas[$valor]=$lista->lista[$valor]['fecha'];
        }
        $ARRAYTODO['fechas']=$arrayfechas;
        $lista->SearchIdReporteByFechaCierreAndIdestablecimiento($conn, $idUsuario,$lista->lista[0]['fecha']);
    }


    $idReporte=$lista->lista['idReporte'];  
    $lista->ListaBiologicosByReportMonth($conn,$idReporte, $idUsuario);
    foreach($lista->lista as $valor=>$value){
        $nombreBiologico = $lista->lista[$valor]['BiologicosNom'];
        $lista->UltimaFechaAndObservacion($conn,$nombreBiologico,$idReporte, $idUsuario );
        $arrayUltimaFilaExpiracion[$valor]=$lista->ultimo['ReportesExpiracionBiologico'];
        $arrayUltimaFilaObservacion[$valor]=$lista->ultimo['ReporteObservaciones'];
        $arrayUltimaFilaArchivo[$valor]=$lista->ultimo['ReportesArchivo'];
        $arrayUltimafechaAdd[$valor]=$lista->ultimo['fecha'];
        $arrayidUsuario[$valor]=$lista->ultimo['Usuarios_idUsuarios'];
    }
    $ARRAYTODO['ultimaexpiracion']=$arrayUltimaFilaExpiracion;
    $ARRAYTODO['ultimaobservacion']=$arrayUltimaFilaObservacion;
    $ARRAYTODO['ultimaarchivo']=$arrayUltimaFilaArchivo;
    $ARRAYTODO['ultimafechaAdd']=$arrayUltimafechaAdd;
    $ARRAYTODO['idUsuario']=$arrayidUsuario;



    
    $lista->SearchReporteMes($conn, $idUsuario,$idReporte);
    $ARRAYTODO['lista']=$lista->vistadetallReporte;
    echo json_encode($ARRAYTODO);       

}
