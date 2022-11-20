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
        public function SearchProporcionByName($conn,$BiologicosNom){
            $productos_select = $conn->prepare("SELECT BiologicosProporcion FROM biologicos WHERE BiologicosNom = :BiologicosNom");
            $productos_select->bindParam(':BiologicosNom', $BiologicosNom);
            $productos_select->execute();
            $this->producto_seleccionado = $productos_select->fetch(PDO::FETCH_ASSOC);
    
        }

        public function UpdateStockProductoByUsuario($conn,
                                        $idBiologico, 
                                        $idUsuario, 
                                        $idLote, 
                                        $stocknuevo){
            $sql = "UPDATE usuariobiologico  set UsuarioBiologicoStock=:stocknuevo where Biologicos_idBiologicos=:idBiologico and Usuarios_idUsuarios=:idUsuario and LoteBiologico_idLoteBiologico=:idLote";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':stocknuevo', $stocknuevo);
            $stmt->bindParam(':idBiologico', $idBiologico);
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':idLote', $idLote);

            return $stmt->execute() ? TRUE : FALSE;
        }
    }
?>