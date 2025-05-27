<?php
    class usuario {
        private $id;
        private $name;
        private $emailInstitucional;
        private $password;
        private $rol;

        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

        public function getName(){
            return $this->name;
        }

        public function setName($name){
            $this->name = $name;
        }

        public function getEmailInstitucional(){
            return $this->emailInstitucional;
        }

        public function setEmailInstitucional($emailInstitucional){
            $this->emailInstitucional = $emailInstitucional;
        }

        public function getPassword(){
            return $this->password;
        }

        public function setPassword($password){
            $this->password = $password;
        }

        public function getRol(){
            return $this->rol;
        }

        public function setRol($rol){
            $this->rol = $rol;
        }

        public function __toString(){
            return "Fabricante - Id: {$this->id} - Nome: {$this->name} - Email: {$this->emailInstitucional}";
        }
    }
?>