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
       

        public function SearchIdByName($conn,$RolesDesc){
            $roles_select = $conn->prepare("SELECT idRoles FROM roles WHERE RolesDesc = :RolesDesc");
            $roles_select->bindParam(':idRoles', $idRoles);
            $roles_select->execute();
            $this->roles_selection = $roles_select->fetch(PDO::FETCH_ASSOC);
        }

        public function SearchNameByCod($conn,$idUsuario,$idRoles){
            $roles_select = $conn->prepare("SELECT rol.RolesDesc FROM
            usuarios usu inner join 
            roles rol on usu.Roles_idRoles=rol.idRoles
            where
            usu.Roles_idRoles= :idRoles and rol.idUsuarios = :idUsuarios");
            $roles_select->bindParam('idUsuario', $idUsuario);
            $roles_select->bindParam(':idRoles', $idRoles);
            $roles_select->execute();
            $this->roles_selection = $roles_select->fetch(PDO::FETCH_ASSOC);
        }

     
    }
?>