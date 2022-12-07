<?php
    class ListaProductos{
        public $productos;
        public $producto_seleccionado;
        public $producto_selec;
        /* De el Gix ps*/
        public $unidad;
        public $unidad_selec;
        /*ata aca noma ah*/
        
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

         /* De el Gix ps*/
         public function ListaUnidad($conexion){
            $unidad_selec = $conexion->prepare("SELECT distinct(BiologicosUnidad) FROM biologicos");
            $unidad_selec->execute();
            $this->unidad = $unidad_selec->fetchALL(PDO::FETCH_ASSOC);
        }
        /*ata aca noma ah*/


    
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
            $productos_select = $conn->prepare("SELECT * FROM biologicos WHERE BiologicosNom = :BiologicosNom");
            $productos_select->bindParam(':BiologicosNom', $BiologicosNom);
            $productos_select->execute();
            $this->producto_seleccionado = $productos_select->fetch(PDO::FETCH_ASSOC);
    
        }
        public function SearchProporcionById($conn,$BiologicosId){
            $productos_select = $conn->prepare("SELECT BiologicosProporcion FROM biologicos WHERE idBiologicos = :BiologicosId");
            $productos_select->bindParam(':BiologicosId', $BiologicosId);
            $productos_select->execute();
            $this->producto_seleccionado = $productos_select->fetch(PDO::FETCH_ASSOC);
    
        }

        public function SearchStockId($conn,$idBiologicos,$idUsuario){
            $productos_select = $conn->prepare("SELECT *FROM biologicos bio 
            INNER JOIN usuariobiologico usu ON bio.idBiologicos=usu.Biologicos_idBiologicos WHERE bio.idBiologicos = :idBiologicos AND usu.Usuarios_idUsuarios=:idUsuario");
            $productos_select->bindParam(':idBiologicos', $idBiologicos);
            $productos_select->bindParam(':idUsuario', $idUsuario);
            $productos_select->execute();
            $this->producto_seleccionado = $productos_select->fetch(PDO::FETCH_ASSOC);
        }


        public function UpdateStockProductoByUsuario($conn,
                                        $idBiologico, 
                                        $idUsuario, 
                                        $stocknuevo){
            $sql = "UPDATE usuariobiologico  set UsuarioBiologicoStock=:stocknuevo where Biologicos_idBiologicos=:idBiologico and Usuarios_idUsuarios=:idUsuario ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':stocknuevo', $stocknuevo);
            $stmt->bindParam(':idBiologico', $idBiologico);
            $stmt->bindParam(':idUsuario', $idUsuario);

            return $stmt->execute() ? TRUE : FALSE;
        }

        public function IngresarProducto($conn,
                                        $BiologicosCod,
                                        $BiologicosNom,
                                        $BiologicosProporcion,
                                        $BiologicosUnidad,
                                        $BiologicosFecha,
                                        $Categoria_idCategoria){
        $sql = "INSERT INTO biologicos
                    (BiologicosCod,
                    BiologicosNom,
                    BiologicosProporcion,
                    BiologicosUnidad,
                    BiologicosFecha,
                    Categoria_idCategoria)
                    Values
                    (:BiologicosCod,
                    :BiologicosNom,
                    :BiologicosProporcion,
                    :BiologicosUnidad,
                    :BiologicosFecha,
                    :Categoria_idCategoria
                    )";
        $stmt = $conn->prepare($sql);
        $stmt ->bindParam(':BiologicosCod',$BiologicosCod);
        $stmt ->bindParam(':BiologicosNom',$BiologicosNom);
        $stmt ->bindParam(':BiologicosProporcion',$BiologicosProporcion);
        $stmt ->bindParam(':BiologicosUnidad',$BiologicosUnidad);
        $stmt ->bindParam(':BiologicosFecha',$BiologicosFecha);
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
                    Categoria_idCategoria=:Categoria_idCategoria, 
                    BiologicosCod=:BiologicosCod,
                    BiologicosNom=:BiologicosNom,
                    BiologicosProporcion= :BiologicosProporcion,
                    BiologicosUnidad=:BiologicosUnidad
                    where idBiologicos=:idBiologicos";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':BiologicosCod',$BiologicosCod);
        $stmt->bindParam(':BiologicosNom',$BiologicosNom);
        $stmt->bindParam(':BiologicosProporcion',$BiologicosProporcion);
        $stmt->bindParam(':BiologicosUnidad',$BiologicosUnidad);
        $stmt->bindParam(':Categoria_idCategoria',$Categoria_idCategoria);
        $stmt->bindParam(':idBiologicos',$idBiologicos);
        return $stmt->execute() ? TRUE : FALSE;
        }
        /* De el Gix ps*/
        public function DeleteProducto($conn,$idBiologicos){
            $sql="DELETE FROM biologicos WHERE idBiologicos=:idBiologicos";
            $stmt = $conn-> prepare($sql);
            $stmt->bindParam(':idBiologicos',$idBiologicos);
            return $stmt->execute() ? TRUE : FALSE;
        }
    }
?>