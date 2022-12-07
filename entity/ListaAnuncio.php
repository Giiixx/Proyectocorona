<?php
    class ListaAnuncio{
        public $anuncio;
        public $anuncio_select;

        public function __construct($conexion){
            $anuncio_select = $conexion-> prepare("Select * from anuncio");
            $anuncio_select->execute();
            $this->anuncio = $anuncio_select-> fetchALL(PDO::FETCH_ASSOC);
        }

        public function init($conexion){
            $anuncio_select = $conexion->prepare("SELECT * FROM anuncio");
            $anuncio_select->execute();
            $this->anuncio = $anuncio_select->fetchALL(PDO::FETCH_ASSOC);
        }
        public function getId($position){
            return $this->anuncio[$position]['idAnuncio'];
        }
        public function getTitulo($position){
            return $this->anuncio[$position]['AnuncioTitulo'];
        }
        public function getMensaje($position){
            return $this->anuncio[$position]['AnuncioMensaje'];
        }
        public function getImg($position){
            return $this->anuncio[$position]['Anuncioimg'];
        }

        public function UpdateAnuncio($conn,
                                    $AnuncioTitulo,
                                    $AnuncioMensaje,
                                    $Anuncioimg,
                                    $idAnuncio
                                    ){
        $sql = "UPDATE anuncio SET
                    AnuncioTitulo=:AnuncioTitulo,
                    AnuncioMensaje=:AnuncioMensaje,
                    Anuncioimg= :Anuncioimg
                    where idAnuncio=:idAnuncio";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':AnuncioTitulo',$AnuncioTitulo);
        $stmt->bindParam(':AnuncioMensaje',$AnuncioMensaje);
        $stmt->bindParam(':Anuncioimg',$Anuncioimg);
        $stmt->bindParam(':idAnuncio',$idAnuncio);
        return $stmt->execute() ? TRUE : FALSE;
        }
    
      
    
        
    }

?>