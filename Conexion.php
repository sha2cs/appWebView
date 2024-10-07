<?php

class Conexion {
    // Definimos las propiedades de la clase para la conexión a la base de datos
    private $host = 'localhost'; // Host de la base de datos
    private $dbname = 'freddy'; // Nombre de la base de datos
    private $usuario = 'admin'; // Nombre de usuario de la base de datos
    private $password = '12345'; // Contraseña de la base de datos

    // Atributos para configurar PDO
    private $atributos = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Configurar PDO para lanzar excepciones en errores
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Modo de recuperación por defecto como array asociativo
    );

    protected $conexion; // Propiedad para almacenar la conexión

    // Método para conectar a la base de datos
    public function conectar() {
        try {
            // Intentamos establecer la conexión a la base de datos usando PDO
            $this->conexion = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", 
            $this->usuario, $this->password, $this->atributos);
            return $this->conexion; // Devolvemos la conexión si es exitosa
            
        } catch(PDOException $e) {
            // Si ocurre un error en la conexión, mostramos un mensaje de error
            echo 'Error conectando con la base de datos: ' . $e->getMessage();
        }
    }
    
    // Método para desconectar de la base de datos
    public function desconectar() {
        $this->conexion = null; // Cerramos la conexión estableciendo la propiedad a null
    }
}
