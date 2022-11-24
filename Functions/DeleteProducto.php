<?php
require '../conections/basededatos.php';
require '../entity/ListaProductos.php';
$borrarProducto = new ListaProductos($conn);
$elim_id = $_GET['id'];


if($borrarProducto->DeleteProducto($conn,$elim_id)
){
    echo "se logro";
}


header('Location:/public_html/templates/datosBiologico/registrarBiologico.php');

?>      
