<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conexionDB = new Conexion();
    $conexion = $conexionDB->conectar();

    $id_usuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $correo_electronico = $_POST['correo_electronico'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroDocumento = $_POST['numeroDocumento'];

    // Actualizar el usuario en la base de datos
    $sql = "UPDATE usuarios SET nombre_usuario = :nombre, correo_electronico = :correo_electronico, id_tipoDocumento = :tipoDocumento, numeroDocumento = :numeroDocumento WHERE id_usuario = :id_usuario";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo_electronico', $correo_electronico);
    $stmt->bindParam(':tipoDocumento', $tipoDocumento);
    $stmt->bindParam(':numeroDocumento', $numeroDocumento);
    $stmt->bindParam(':id_usuario', $id_usuario);

    if ($stmt->execute()) {
        echo "Usuario actualizado exitosamente.";
        // Redirigir o mostrar el listado de usuarios
        header("Location: mostrar.php"); // Cambia esto si quieres redirigir a otro lugar
        exit;
    } else {
        echo "Error al actualizar el usuario.";
    }
} else {
    echo "Método no permitido.";
}
?>