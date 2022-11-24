<?php
    class ListaCategoria{
        public $categoria;
        public $categoria_selection;

        public function __construct($conexion){
            $categoria_select = $conexion->prepare("Select * From categoria");
            $categoria_select->execute();
            $this->categoria = $categoria_select->fetchALL(PDO::FETCH_ASSOC);
        }
        

        public function getId($position){
            return $this->categoria[$position]['idCategoria'];
        }
        public function getNombre($position){
            return $this->categoria[$position]['CategoriaDesc'];
        }
/* De el Gix ps*/
        public function SearchByCod($conn,$idBiologicos,$idCategoria){
            $categoria_select = $conn->prepare( "SELECT cat.CategoriaDesc FROM biologicos bio inner join categoria cat on cat.idCategoria=bio.Categoria_idCategoria where bio.idBiologicos=:idBiologicos and cat.idCategoria=:idCategoria");
           $categoria_select->bindParam(':idBiologicos',$idBiologicos);
           $categoria_select->bindParam(':idCategoria',$idCategoria);
           $categoria_select->execute();
           $this->categoria_select = $categoria_select->fetch(PDO::FETCH_ASSOC);
        }
        public function Buscarnombre($conn,$idCategoria){
            $categoria_select=$conn->prepare("SELECT cat.CategoriaDesc FROM biologicos bio inner join categoria cat on cat.idCategoria=bio.Categoria_idCategoria where bio.Categoria_idCategoria=:idCategoria");
            $categoria_select->bindParam(':idCategoria',$idCategoria);
            $categoria_select->execute();
            $this->categoria_selection=$categoria_select->fetch(PDO::FETCH_ASSOC);
        }
        public function BuscarCodigo($conn,$CategoriaDesc){
            $categoria_select = $conn->prepare("SELECT idCategoria FROM categoria WHERE CategoriaDesc = :CategoriaDesc");
            $categoria_select->bindParam(':CategoriaDesc', $CategoriaDesc);
            $categoria_select -> execute();
            $this->categoria_selection=$categoria_select->fetch(PDO::FETCH_ASSOC);
        }
     /*ata aca*/
    }
?>