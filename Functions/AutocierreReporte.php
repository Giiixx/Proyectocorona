<?php
require_once '../conections/basededatos.php';
require_once '../entity/ListaDetalleReporte.php';
require_once '../entity/ListaProductos.php';
require_once '../entity/ListaUsuarioBiologico.php';
require_once '../entity/Usuario.php';


$prueba  = new ListaDetalleReporte($conn);


$prueba->IngresarLotes($conn,'OCLA');


?>