<?php
require '../conections/basededatos.php';
require '../entity/ListaProductos.php';

$UnidadBiologico = new ListaProductos($conn);
$UnidadBiologico->ListaUnidad($conn);
echo $UnidadBiologico->unidad_seleccionada['BiologicosUnidad'];



    
?>