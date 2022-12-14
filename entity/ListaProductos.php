<?php
    class ListaProductos{
        public $productos;
        public $producto_seleccionado;
        
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
        public function SearchIdByName($conn,$BiologicosNom){
            $productos_select = $conn->prepare("SELECT idBiologicos FROM biologicos WHERE BiologicosNom = :BiologicosNom");
            $productos_select->bindParam(':BiologicosNom', $BiologicosNom);
            $productos_select->execute();
            $this->producto_seleccionado = $productos_select->fetch(PDO::FETCH_ASSOC);
    
        }

        public function IngresarProducto($conn,
                                        $BiologicosCod,
                                        $BiologicosNom,
                                        $BiologicosProporcion,
                                        $BiologicosUnidad,
                                        $Categoria_idCategoria){
        $sql = "INSERT INTO biologicos
                    (BiologicosCod,
                    BiologicosNom,
                    BiologicosProporcion,
                    BiologicosUnidad,
                    Categoria_idCategoria)
                    Values
                    (:BiologicosCod,
                    :BiologicosNom,
                    :BiologicosProporcion,
                    :BiologicosUnidad,
                    :Categoria_idCategoria
                    )";
        $stmt = $conn->prepare($sql);
        $stmt ->bindParam(':BiologicosCod',$BiologicosCod);
        $stmt ->bindParam(':BiologicosNom',$BiologicosNom);
        $stmt ->bindParam(':BiologicosProporcion',$BiologicosProporcion);
        $stmt ->bindParam(':BiologicosUnidad',$BiologicosUnidad);
        $stmt ->bindParam(':Categoria_idCategoria',$Categoria_idCategoria);

        return $stmt->execute() ? TRUE : FALSE;
        }

        public function UpdateProducto($conn,
                                    $BiologicosCod,
                                    $BiologicosNom,
                                    $BiologicosProporcion,
                                    $BiologicosUnidad,
                                    $Categoria_idCategoria,
                                    $idBiologicos){
        $sql = "UPDATE biologicos SET 
                   BiologicosCod=:BiologicosCod,
                   BiologicosNom=:BiologicosNom,
                   BiologicosProporcion= :BiologicosProporcion,
                   BiologicosUnidad=:BiologicosUnidad,
                   Categoria_idCategoria=:Categoria_idCategoria
                   where idBiologicos=:idBiologicos";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':BiologicosCod',$BiologicosCod);
        $stmt->bindParam(':BiologicosNom',$BiologicosNom);
        $stmt->bindParam(':BiologicosProporcion',$BiologicosProporcion);
        $stmt->bindParam(':BiologicosUnidad');
        $stmt->bindParam(':Categoria_idCategoria');
        $stmt->bindParam(':idBiologicos',$idBiologicos);
        return $stmt->execute() ? TRUE : FALSE;
        }
        public function DeleteProducto($conn,$idBiologicos){
            $sql="DELETE FROM biologicos WHERE idBiologicos=:idBiologicos";
            $stmt = $conn-> prepare(sql);
            $stmt->bindParam(':idBiologicos',$idBiologicos);
            return $stmt->execute() ? TRUE : FALSE;
        }


    }
?>