<?php

    class Conexion {

        private $host = 'sql313.infinityfree.com';
        private $dbname = 'if0_37481239_XXX';
        private $usuario = 'if0_37481239';
        private $password = 'L6gcHruO87Ujaev';
        private $atributos = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC); 

        protected $conexion;

        public function conectar(){
            try {

                $this->conexion = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", 
                    $this->usuario, $this->password, $this->atributos);
                return $this->conexion;

            } catch(PDOException $e) {
                echo 'Error conectando con la base de datos: ' . $e->getMessage();
            }
    
        }

        public function desconectar() {
            $this->conexion = null;
        }
    }