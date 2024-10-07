<?php
include ("conexion.php");

$conexionDB = new Conexion();
$conexion = $conexionDB->conectar();

if ($conexion) {
    $nombre = $_POST['nombre'];
    $correo_electronico = $_POST['correo_electronico'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroDocumento = $_POST['numeroDocumento'];

    $sql = "INSERT INTO usuarios (nombre_usuario, correo_electronico, id_tipoDocumento, numeroDocumento) VALUES (:nombre, :correo_electronico, :tipoDocumento, :numeroDocumento)";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo_electronico', $correo_electronico);
    $stmt->bindParam(':tipoDocumento', $tipoDocumento);
    $stmt->bindParam(':numeroDocumento', $numeroDocumento);

    if ($stmt->execute()) {
        echo "Registro exitoso";
    } else {
        echo "Error: no se pudo realizar el registro.";
    }

} else {
    echo "No se pudo conectar a la base de datos.";
}
?>