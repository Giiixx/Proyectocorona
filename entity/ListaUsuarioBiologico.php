<?php
    class ListaUsuariosBiologico{
        public $usuariosbiologico;
        public $usuariosbiologico_selection;

        public function __construct($conexion){
<<<<<<< HEAD
            $usuariosbiologico_select = $conexion->prepare("SELECT * From UsuarioBiologico");
=======
            $usuariosbiologico_select = $conexion->prepare("Select * From UsuarioBiologico");
>>>>>>> gix
            $usuariosbiologico_select->execute();
            $this->usuariosbiologico = $usuariosbiologico_select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function getId($position){
            return $this->usuariosbiologico[$position]['idUsuarioBiologico'];
        }
        public function getRis($position){
            return $this->usuariosbiologico[$position]['UsuarioBiologicoStock'];
        }
        public function getEstablecimiento($position){
            return $this->usuariosbiologico[$position]['Biologicos_idBiologicos'];
        }
        public function getNombre($position){
            return $this->usuariosbiologico[$position]['Usuarios_idUsuarios'];
        }
<<<<<<< HEAD
=======
      
     
>>>>>>> gix
    }
?>