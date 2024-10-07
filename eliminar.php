<?php
require_once 'conexion.php';

if (isset($_GET['id'])) {
    $conexionDB = new Conexion();
    $conexion = $conexionDB->conectar();

    $id_usuario = $_GET['id'];

    // Eliminar el usuario de la base de datos
    $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);

    if ($stmt->execute()) {
        echo "Usuario eliminado exitosamente.";
        header("Location: mostrar.php"); // Redirigir después de eliminar
        exit;
    } else {
        echo "Error al eliminar el usuario.";
    }
} else {
    echo "No se ha especificado un ID de usuario.";
}
?>