<?php
include 'Conexion.php';

$conexionDam = new Conexion();
$conn = $conexionDam->conectar();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $query = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();


    header('Location: index.php');
    exit();
}
?>