<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaDetalleReporte.php';
require_once '../entity/Usuario.php';

session_start();
date_default_timezone_set("America/Bogota");
$fecha_actual = date("Y-m-d");
$hora = date("H:i:s");
if(isset($_SESSION['user_id'])){
    //objetos Dettale Reporte Y Biologicos
    $agregarReporte = new ListaDetalleReporte($conn);
    $agregarReporte->SearchReporteById($conn,$_SESSION["myuser_obj"]->getId());
    $Idreporte=$agregarReporte->reporte['idReporte'];

    
    /*********************FECHACIERREREPORTE************************ */
    $agregarReporte->UpdateReportesUsuario($conn,$fecha_actual,$hora,$Idreporte);
    /*********************CREARNEWREPORTE************************ */
    $MES=date("m");
    $ANO=date("Y");
    $fechaApertura=$ANO.'-'.$MES.'-6';
    $agregarReporte->IngresarReportesUsuario($conn,"Reporte ".$_SESSION['myuser_obj']->getEstablecimiento(),$_SESSION["myuser_obj"]->getId(),$fechaApertura);  
    
    /******************************************************************** */

    
    header('Location:../index.php');

}



?>      