<?php

$servername = "localhost";
$username = "admin";      
$password = "admin";       
$dbname = "dam";            


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Captura los datos enviados desde el formulario 
$nombres = $conn->real_escape_string($_POST['nombres']);
$apellidos = $conn->real_escape_string($_POST['apellidos']);
$tipodocumento = $conn->real_escape_string($_POST['tipodocumento']);
$ndoc = $conn->real_escape_string($_POST['ndoc']);
$telefono = $conn->real_escape_string($_POST['telefono']);
$correo = $conn->real_escape_string($_POST['correo']);


$sql = "INSERT INTO usuarios (nombres, apellidos, tipodocumento, ndoc, telefono, correo) 
        VALUES ('$nombres', '$apellidos', '$tipodocumento', '$ndoc', '$telefono', '$correo')";

if ($conn->query($sql) === TRUE) {
    echo "Datos guardados correctamente:<br>";
    echo "Nombres: $nombres<br>";
    echo "Apellidos: $apellidos<br>";
    echo "Tipo de Documento: $tipodocumento<br>";
    echo "Número de Documento: $ndoc<br>";
    echo "Teléfono: $telefono<br>";
    echo "Correo: $correo<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<button onclick="location.href='index.php'">Finalizar</button>
