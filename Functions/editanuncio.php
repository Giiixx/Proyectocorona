<?php
require '../conections/basededatos.php';
require '../entity/ListaAnuncio.php';

$editarAnuncio = new ListaAnuncio($conn);


if($editarAnuncio->UpdateAnuncio($conn,
$_POST['titulo'],
$_POST['mensaje'],
"dawddwad",
1)
){
    echo "se logro";
}


header('Location:../templates/configuracion/editaranuncio.php');

?>