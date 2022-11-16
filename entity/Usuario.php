<?php
    class Usuario{
        private $id;
        private $ris;
        private $establecimiento;
        private $nombre;
        private $rol;

        public function __construct($id, $ris, $establecimiento, $nombre) {
            $this->id = $id;
            $this->ris = $ris;
            $this->establecimiento = $establecimiento;
            $this->nombre = $nombre;
        }

        public function setById($id, $conn) {
            $consult = $conn->prepare('SELECT * FROM usuarios WHERE idUsuarios=:id');
            $consult->bindParam(':id', $id);
            $consult->execute();
            $result = $consult->fetch(PDO::FETCH_ASSOC);

            $this->id = $result['idUsuarios'];
            $this->ris = $result['UsuarioRis'];
            $this->establecimiento = $result['UsuariosDescEstablecimiento'];
            $this->nombre = $result['UsuarioNombre'];
            $this->rol = $result['Roles_idRoles'];
        }

        public function setId($id) {
            $this->id = $id;
        }
        public function setRis($ris) {
            $this->ris = $ris;
        }
        public function setEstablecimiento($establecimiento) {
            $this->establecimiento = $establecimiento;
        }
        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }

        public function getId() {
            return $this->id;
        }
        public function getRis() {
            return $this->ris;
        }
        public function getEstablecimiento() {
            return $this->establecimiento;
        }
        public function getNombre() {
            return $this->nombre;
        }
        public function getRegistros() {
            return $this->cant_registros;
        }
        public function getRol() {
            return $this->rol;
        }
    }
?>