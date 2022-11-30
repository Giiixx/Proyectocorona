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
    $lista->SearchReportesByUsuario($conn, $_SESSION["myuser_obj"]->getId());
    foreach ($lista->detalleReporte as $valor => $value){
        if($lista->detalleReporte[$valor]['ReporteNombre']."-Cierre ".$lista->detalleReporte[$valor]['ReporteFechaCierre']==$_POST['nombre']){
            $idReporte =  $lista->detalleReporte[$valor]['idReporte'];
        }
    }

    $lista->SearchReporteMes($conn, $_SESSION["myuser_obj"]->getId(),$idReporte);

    echo json_encode($lista->vistadetallReporte);

}
?>