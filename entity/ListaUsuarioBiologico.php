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

        public function SearchStockByNameBiologico($conexion,$NombreBiologico,$idUsuario){
            $usuariosbiologico_select = $conexion->prepare("SELECT 
            *
            FROM
            biologicos bio
            INNER JOIN
            usuariobiologico usubio ON bio.idBiologicos = usubio.Biologicos_idBiologicos
            WHERE
            bio.BiologicosNom=:nombre AND usubio.Usuarios_idUsuarios=:idusuario");
            
            $usuariosbiologico_select->bindParam(':nombre', $NombreBiologico);
            $usuariosbiologico_select->bindParam(':idusuario', $idUsuario);
            $usuariosbiologico_select->execute();
            $this->lotesBiologico = $usuariosbiologico_select->fetch(PDO::FETCH_ASSOC);
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
                                $usuarioid){
            $sql = "INSERT INTO usuariobiologico
                        (UsuarioBiologicoStock,
                        Biologicos_idBiologicos,
                        Usuarios_idUsuarios)
                    VALUES
                        (:stock,
                        :biologicoid,
                        :usuarioid)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':biologicoid', $biologicoid);
            $stmt->bindParam(':usuarioid', $usuarioid);

            return $stmt->execute() ? TRUE : FALSE;

        }

        public function SearchIdUsuBio($conn,$idusuario,$idbiologico){
            $productos_select = $conn->prepare("SELECT idUsuarioBiologico from usuariobiologico where Usuarios_idUsuarios=:idusuario and Biologicos_idBiologicos=:idbiologico ");
            $productos_select->bindParam(':idusuario', $idusuario);
            $productos_select->bindParam(':idbiologico', $idbiologico);
            $productos_select->execute();
            $this->search = $productos_select->fetch(PDO::FETCH_ASSOC);
    
        }



    }
?>