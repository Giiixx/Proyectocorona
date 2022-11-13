<?php
require '../conections/basededatos.php';
require '../entity/ListaDetalleReporte.php';
$borrarDetalle = new ListaDetalleReporte($conn);
$elim_id = $_GET['id'];


if($borrarDetalle->DeleteDetallleReporte($conn,$elim_id)
){
    echo "se logro";
}


header('Location:/public_html/templates/index.php');

?>      