<?php
    class ListaUsuarios{
        public $usuarios;
        public $vistausuario;

        public function __construct($conexion){
            $usuarios_select = $conexion->prepare("Select * From usuarios");
            $usuarios_select->execute();
            $this->usuarios = $usuarios_select->fetchALL(PDO::FETCH_ASSOC);
        }

        public function getId($position){
            return $this->usuarios[$position]['idUsuarios'];
        }
        public function getRis($position){
            return $this->usuarios[$position]['UsuarioRis'];
        }
        public function getEstablecimiento($position){
            return $this->usuarios[$position]['UsuariosDescEstablecimiento'];
        }
        public function getNombre($position){
            return $this->usuarios[$position]['UsuarioNombre'];
        }
        public function getContrasena($position){
            return $this->usuarios[$position]['UsuariosContrasena'];
        }
        public function getId_Roles($position){
            return $this->usuarios[$position]['Roles_idRoles'];
        }
        public function VistaUsuario($conn){
            $usuarios_select= $conn->prepare("SELECT  usu.UsuarioRis, usu.UsuariosDescEstablecimiento ,usu.UsuarioNombre,usu.UsuariosContrasena,  rol.RolesDesc  FROM
            usuarios usu inner join 
            roles rol on usu.Roles_idRoles=rol.idRoles");
            $usuarios_select->execute();
            $this->vistausuario = $select->FetchAll(PDO::FETCH_ASSOC);

        }
    }
?>