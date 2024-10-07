<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "based_datos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$tipoDocumento = $_POST['tipoDocumento'];
$numeroDocumento = $_POST['numeroDocumento'];
$accion = $_POST['accion'];


if ($accion == 'crear') {
    $sql = "INSERT INTO usuarios (nombre, id_tipo_documento, numero_de_documento) VALUES ('$nombre', '$tipoDocumento', '$numeroDocumento')";
} elseif ($accion == 'editar') {
    $sql = "UPDATE usuarios SET nombre='$nombre', id_tipo_documento='$tipoDocumento', numero_de_documento='$numeroDocumento' WHERE id_usuario=$id";
} elseif ($accion == 'eliminar') {
    $sql = "DELETE FROM usuarios WHERE id_usuario=$id";
}

if ($conn->query($sql) === TRUE) {
    echo "Acción realizada exitosamente";   
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();

header("Location: index.php");
exit();
?>