<?php
    class ListaUsuariosBiologico{
        public $usuariosbiologico;
        public $usuariosbiologico_selection;
        public $lotesBiologico;
        public $search;

        public function __construct($conexion){
            $usuariosbiologico_select = $conexion->prepare("SELECT * From usuariobiologico");
            $usuariosbiologico_select->execute();
            $this->usuariosbiologico = $usuariosbiologico_select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function getId($position){
            return $this->usuariosbiologico[$position]['idUsuarioBiologico'];
        }
        public function getLote($position){
            return $this->usuariosbiologico[$position]['UsuarioBiologicoLote'];
        }
        public function getStock($position){
            return $this->usuariosbiologico[$position]['UsuarioBiologicoStock'];
        }
        
        public function getIdBiologico($position){
            return $this->usuariosbiologico[$position]['Biologicos_idBiologicos'];
        }
        public function getIdUsuario($position){
            return $this->usuariosbiologico[$position]['Usuarios_idUsuarios'];
        }

        public function SearchLotesandStockByNameBiologico($conexion,$NombreBiologico,$idUsuario){
            $usuariosbiologico_select = $conexion->prepare("SELECT 
            bio.idBiologicos,
            bio.BiologicosNom,
            bio.BiologicosProporcion,
            bio.Categoria_idCategoria,
            usubio.UsuarioBiologicoStock,
            usubio.Usuarios_idUsuarios,
            lot.LoteBiologicoDescripcion
            FROM
            biologicos bio
            INNER JOIN
            usuariobiologico usubio ON bio.idBiologicos = usubio.Biologicos_idBiologicos
            INNER JOIN
            lotebiologico lot ON usubio.LoteBiologico_idLoteBiologico = lot.idLoteBiologico
            WHERE
            bio.BiologicosNom=:nombre AND usubio.Usuarios_idUsuarios=:idusuario");
            
            $usuariosbiologico_select->bindParam(':nombre', $NombreBiologico);
            $usuariosbiologico_select->bindParam(':idusuario', $idUsuario);
            $usuariosbiologico_select->execute();
            $this->lotesBiologico = $usuariosbiologico_select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function InsertLote($conexion,
                                $lotesDesc){
            $sql = "INSERT INTO lotebiologico
                        (LoteBiologicoDescripcion)
                    VALUES
                        (:nombrelote)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombrelote', $lotesDesc);

            return $stmt->execute() ? TRUE : FALSE;
            

        }
        public function InsertUsuarioBiologico($conexion,
                                $stock,
                                $biologicoid,
                                $usuarioid,
                                $loteid){
            $sql = "INSERT INTO usuariobiologico
                        (UsuarioBiologicoStock,
                        Biologicos_idBiologicos,
                        Usuarios_idUsuarios,
                        LoteBiologico_idLoteBiologico)
                    VALUES
                        (:stock,
                        :biologicoid,
                        :usuarioid,
                        :loteid)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':biologicoid', $biologicoid);
            $stmt->bindParam(':usuarioid', $usuarioid);
            $stmt->bindParam(':loteid', $loteid);

            return $stmt->execute() ? TRUE : FALSE;

        }

        public function SearchIdLoteByName($conn,$loteNom){
            $productos_select = $conn->prepare("SELECT idLoteBiologico FROM lotebiologico WHERE LoteBiologicoDescripcion = :loteNom");
            $productos_select->bindParam(':loteNom', $loteNom);
            $productos_select->execute();
            $this->search = $productos_select->fetch(PDO::FETCH_ASSOC);
    
        }
        public function SearchIdUsuBio($conn,$idusuario,$idbiologico,$idlote){
            $productos_select = $conn->prepare("SELECT idUsuarioBiologico from usuariobiologico where Usuarios_idUsuarios=:idusuario and Biologicos_idBiologicos=:idbiologico and LoteBiologico_idLoteBiologico=:idlote");
            $productos_select->bindParam(':idusuario', $idusuario);
            $productos_select->bindParam(':idbiologico', $idbiologico);
            $productos_select->bindParam(':idlote', $idlote);
            $productos_select->execute();
            $this->search = $productos_select->fetch(PDO::FETCH_ASSOC);
    
        }



    }
?>