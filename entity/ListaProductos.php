<?php
    class ListaProductos{
        public $productos;
        public $producto_seleccionado;
        public $producto_selec;
        
        public function __construct($conexion) {
            $productos_select = $conexion->prepare("SELECT * FROM biologicos");
            $productos_select->execute();
            $this->productos = $productos_select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function init($conexion){
            $productos_select = $conexion->prepare("SELECT * FROM biologicos");
            $productos_select->execute();
            $this->productos = $productos_select->fetchALL(PDO::FETCH_ASSOC);
        }


        /*public function searchByCodigo($conexion, $codigo){
            $productos_select = $conexion->prepare("SELECT id FROM productos WHERE codigo = :codigo");
            $productos_select->bindParam(':codigo', $codigo);
            $productos_select->execute();
            $this->producto_seleccionado = $productos_select->fetch(PDO::FETCH_ASSOC);
        }

        public function getCantidad(){
            $points = 0;
            foreach ($this->productos as $valor=>$value){
                $points++;
            }
            return $points;
        }

        public function getLarge(){
            return count($this->productos);
        }*/

        public function getId($position){
            return $this->productos[$position]['idBiologicos'];
        }

        public function getCodigo($position){
            return $this->productos[$position]['BiologicosCod'];
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

        public function SearchIdByName($conn,$BiologicosNom){
            $productos_select = $conn->prepare("SELECT idBiologicos FROM biologicos WHERE BiologicosNom = :BiologicosNom");
            $productos_select->bindParam(':BiologicosNom', $BiologicosNom);
            $productos_select->execute();
            $this->producto_seleccionado = $productos_select->fetch(PDO::FETCH_ASSOC);
    
        }
        public function SearchStockByCod($conn,$idUsuarioBiologico,$BiologicosCod){
            $productos_select = $conn->prepare("SELECT usu.UsuarioBiologicoStock FROM biologicos bio inner join usuariobiologico usu on bio.idBiologicos=usu.Biologicos_idBiologicos where usu.Usuarios_idUsuarios = :idUsuarioBiologico and bio.BiologicosCod = :BiologicosCod");
            $productos_select->bindParam(':idUsuarioBiologico', $idUsuarioBiologico);
            $productos_select->bindParam(':BiologicosCod', $BiologicosCod);
            $productos_select->execute();
            $this->producto_selec = $productos_select->fetch(PDO::FETCH_ASSOC);
    
        }

    }
?>