<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaDetalleReporte.php';
require_once '../entity/Usuario.php';


    $lote  = new ListaDetalleReporte($conn);
    $lote->ListaLotes($conn);

    foreach($lote->lote as $valor=>$value){
        $arraylote[$valor]=$lote->lote[$valor]['LotesDescripcion'];
    }

    echo json_encode($arraylote);

?>