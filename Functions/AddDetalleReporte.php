<?php
    require '../conections/basededatos.php';
    require '../entity/ListaDetalleReporte.php';

    $agregarDetalle = new ListaDetalleReporte($conn);

    if($agregarDetalle->IngresarDetalleReporte($conn,1,2,3,4,2,"2020-03-25",'lote',2,"observaciones","archivo","2020-03-25 12:12:12",1,1)
    ){
        echo "se logro";
    }
?>