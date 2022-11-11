<?php
    class ListaProductos{
        public $productos;
        public $producto_seleccionado;
    }

    public function _construct($conexion){
        $productos_select = $conexion->prepare("SELECT * FROM biologicos");
        $producto_select->execute();
        $this->productos = $productos_select->fetchALL(PDO::FETCH_ASSOC);
    }

    public function init($conexion){
        $productos_select = $conexion->prepare("SELECT * FROM biologicos");
        $producto_select->execute();
        $this->productos = $productos_select->fetchALL(PDO::FETCH_ASSOC);
    }
?>