<?php
    class ListaCategoria{
        public $categoria;
        public $categoria_selection;

        public function __construct($conexion){
            $categoria_select = $conexion->prepare("Select * From Categoria");
            $categoria_select->execute();
            $this->categoria = $categoria_select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function getId($position){
            return $this->categoria[$position]['idCategoria'];
        }
        public function getRis($position){
            return $this->categoria[$position]['CategoriaDesc'];
        }
       
     
    }
?>