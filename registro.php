<?php
require_once 'conexion.php';

$conexionDB = new Conexion();
$conexion = $conexionDB->conectar();

if ($conexion) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $tipo_documento = $_POST['tipo_documento'];
    $numero_documento = $_POST['numero_documento'];

    $sql = "INSERT INTO usuarios (nombre_usuario, email, id_tipo_documento, numero_documento) VALUES (:nombre, :email, :tipo_documento, :numero_documento)";
    
    // Preparar y ejecutar la consulta usando PDO
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tipo_documento', $tipo_documento);
    $stmt->bindParam(':numero_documento', $numero_documento);


} else {
   echo "No se pudo conectar a la base de datos.";
}

if ($stmt->execute()) {
    echo "Registro exitoso";
 } else {
     echo "Error: no se pudo realizar el registro.";
 }



?>
    
</div>

    


 