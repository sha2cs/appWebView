<?php
include("../config/Conexion.php");
$conexionDam = new Conexion();
$conexion = $conexionDam->conectar();

$id = $_GET['id_paciente'];


$sql = "DELETE FROM pacientes WHERE id_paciente = :id_paciente";

$stmt = $conexion->prepare($sql);
$stmt->bindParam("id_paciente", $id, PDO::PARAM_INT);
$stmt->execute();
if ($stmt==TRUE) {
    header('Location: ../index.php');
} else {
    echo 'Error al insertar datos';
}