<?php
require '../conections/basededatos.php';
require '../entity/ListaProductos.php';

$productos  = new ListaProductos($conn);
foreach($productos->productos as $valor=>$valor){
    if($productos->getNombre($valor)==$_POST['aux']){
        $dosis=$productos->getProporcion($valor);
    }
}
echo $dosis;

?>