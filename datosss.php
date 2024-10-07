<?php
$servername = "localhost";
$username = "admon";
$password = "1234";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$fechaNac = $_POST['fechaNac'];
$fechaIng = $_POST['fechaIng'];
$tipoDoc = $_POST['tipoDoc'];
$numDoc = $_POST['numDoc'];
$accion = $_POST['accion'];


if ($accion == 'crear') {
    $sql = "INSERT INTO pacientes (nombre, apellido1, apellido2, fecha_nacimiento, fecha_ingreso, id_tipo_doc, numero_doc ) VALUES ('$nombre', '$apellido1', '$apellido2', '$fechaNac', '$fechaIng', '$tipoDoc', '$numDoc')";
} elseif ($accion == 'editar') {
    $sql = "UPDATE pacientes SET nombre='$nombre', apellido1='$apellido1', apellido2='$apellido2', fecha_nacimiento='$fechaNac', fecha_ingreso='$fechaIng', id_tipo_doc='$tipoDoc', numero_doc='$numDoc' WHERE id_doc=$id";
} elseif ($accion == 'eliminar') {
    $sql = "DELETE FROM pacientes WHERE id_doc=$id";
} else {
    die("Acción no válida: " . $accion);
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