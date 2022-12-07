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
    $lista->SearchReporteById($conn,$idUsuario);
    $idReporte = $lista->reporte['idReporte'];
    $arrayfechas[]="";      
    
    

    if(isset($_POST['fecha'])){
        $lista->SearchReportesEstablecimientosAcualesJs1($conn,$_POST['fecha'],$_POST['nombre']);

        echo json_encode($lista->lista);
        

    }else{
        $lista->ListaFechasUsuarioReporte($conn,  $idUsuario, $idReporte);   
        foreach($lista->detalleReporte as $valor=>$value){
            $arrayfechas[$valor]=$lista->detalleReporte[$valor]['fecha'];
        }
        $lista->SearchReportesEstablecimientosAcualesJs($conn,$_POST['nombre']);
        $ARRAYTODO['lista']=$lista->lista;
        $ARRAYTODO['fechas']=$arrayfechas;

        echo json_encode($ARRAYTODO);
    }

}
