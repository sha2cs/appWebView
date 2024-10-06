<?php
require_once 'conexion.php';

if (isset($_GET['id'])) {
    $conexionDam = new Conexion();
    $conexion = $conexionDam->conectar();

    $id_usuario = $_GET['id'];

    $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);

    if ($stmt->execute()) {
        echo "Usuario eliminado exitosamente.";
        header("Location: visualizar.php"); 
        exit;
    } else {
        echo "Error al eliminar el usuario.";
    }
} else {
    echo "No se ha especificado un ID de usuario.";
}
?>