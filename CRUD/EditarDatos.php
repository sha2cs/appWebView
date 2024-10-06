<?php
include("../config/Conexion.php");
$conexionDam = new Conexion();
$conexion = $conexionDam->conectar();

$id = $_POST['idM'];
$nombres = $_POST['nombresM'];
$apellidos = $_POST['apellidosM'];
$tipoDeDocumento = $_POST['tipoDeDocumentoM'];
$documento = $_POST['documentoM'];
$estado = $_POST['estadoM'];
$edad = $_POST['edadM'];

$sql = "UPDATE pacientes SET nombres='$nombres', apellidos='$apellidos', id_tipoDocumento='$tipoDeDocumento', documento='$documento', id_estado='$estado', edad='$edad' WHERE id_paciente='$id'";

if ($resultado = $conexion->query($sql)) {
    header('Location:../index.php');
} else {
    echo 'Error al editar datos';
}