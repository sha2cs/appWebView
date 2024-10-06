<?php
require_once "conexion.php";

$conexionDam = new Conexion();
$conexion = $conexionDam->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $nombre_usuario= $_POST['nombre_usuario'];
    $email = $_POST['email'];
    $tipoDocumento= $_POST['id_tipo_documento'];
    $numero_documento = $_POST['numero_documento'];
    


    try {
        $sql = $conexion->prepare("
            UPDATE usuarios SET
                nombre_usuario = :nombre_usuario,
                email = :email,
                id_tipo_documento = :id_tipo_documento,
                numero_documento = :numero_documento
            WHERE id_usuario = :id_usuario");

        $sql->bindParam(':nombre_usuario', $nombre_usuario);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':id_tipo_documento', $tipoDocumento);
        $sql->bindParam(':numero_documento', $numero_documento);
        $sql->bindParam(':id_usuario', $id_usuario);
        
        
        $sql->execute();

        echo "Usuario actualizado con éxito.";

    } catch (PDOException $e) {
        echo "Error al actualizar el usuario:". $e->getMessage();
    }
}