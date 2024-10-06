<?php
    include ("../config/Conexion.php");
    $conexionDam = new Conexion();
    $conexion = $conexionDam->conectar();
    

    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $tipoDeDocumento = $_POST['tipoDeDocumento'];
    $documento = $_POST['documento'];
    $estado = $_POST['estado'];
    $edad = $_POST['edad'];

    
    $sql = "INSERT INTO pacientes (nombres, apellidos, id_tipoDocumento, documento, id_estado, edad) VALUES ('$nombres', '$apellidos', '$tipoDeDocumento', '$documento', '$estado', '$edad')";
    $resultado = $conexion->query($sql);
    if ($resultado==TRUE) {
        header('Location: ../index.php');
    } else {
        echo 'Error al insertar datos';
    }
?>