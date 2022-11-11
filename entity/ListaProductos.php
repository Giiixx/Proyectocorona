<?php
    class ListaProductos{
        public $productos;
        public $producto_seleccionado;
    

        public function __construct($conexion){
            $productos_select = $conexion->prepare("SELECT * FROM biologicos");
            $productos_select->execute();
            $this->productos = $productos_select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function init($conexion){
            $productos_select = $conexion->prepare("SELECT * FROM biologicos");
            $productos_select->execute();
            $this->productos = $productos_select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function getId($position){
            return $this->productos[$position]['idBiologicos'];
        }
        public function getCodigo($position){
            return $this->productos[$position]['BiologicosdesCod'];
        }
        public function getNombre($position){
            return $this->productos[$position]['BiologicosNom'];
        }
        public function getProporcion($position){
            return $this->productos[$position]['BiologicosProporcion'];
        }
        public function getUnidad($position){
            return $this->productos[$position]['BiologicosUnidad'];
        }
        public function getId_cat($position){
            return $this->productos[$position]['Categoria_idCategoria'];
        }
    }
?>