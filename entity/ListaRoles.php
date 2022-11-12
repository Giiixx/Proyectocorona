<?php
    class ListaRoles{
        public $roles;
        public $roles_selection;

        public function __construct($conexion){
            $roles_select = $conexion->prepare("Select * from roles");
            $roles_select->execute();
            $this->roles = $roles_select->fetchALL(PDO::FETCH_ASSOC);
        }

      
        
        public function getId($position){
            return $this->roles[$position]['idRoles'];
        }
        public function getRolesDesc($position){
            return $this->roles[$position]['RolesDesc'];
        }
       
     
    }
?>