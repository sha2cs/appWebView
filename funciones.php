<?php
// Definimos las credenciales de conexión a la base de datos
$servername = "localhost"; // Nombre del servidor
$username = "admin"; // Nombre de usuario de la base de datos
$password = "12345"; // Contraseña de la base de datos
$dbname = "freddy"; // Nombre de la base de datos

// Establecemos la conexión a la base de datos usando MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificamos si hubo algún error en la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); // Mostramos un mensaje de error y detenemos la ejecución
}

// Recibimos los datos enviados desde el formulario mediante POST
$id = $_POST['id']; // ID del usuario (usado para editar y eliminar)
$nombre = $_POST['name']; // Nombre del usuario
$tipoDocumento = $_POST['documenType']; // Tipo de documento del usuario
$numeroDocumento = $_POST['documentNumber']; // Número de documento del usuario
$address = $_POST['address']; // Dirección del usuario
$accion = $_POST['action']; // Acción a realizar (crear, editar, eliminar)

// Dependiendo de la acción, preparamos la consulta correspondiente
if ($accion == 'crear') {
    // Consulta para insertar un nuevo usuario
    $sql = "INSERT INTO users (name, id_document_type, document_number, address) VALUES ('$nombre', '$tipoDocumento', '$numeroDocumento', '$address')";
} elseif ($accion == 'editar') {
    // Consulta para actualizar un usuario existente
    $sql = "UPDATE users SET name='$nombre', id_document_type='$tipoDocumento', document_number='$numeroDocumento', address='$address' WHERE id_user=$id";
} elseif ($accion == 'eliminar') {
    // Consulta para eliminar un usuario
    $sql = "DELETE FROM users WHERE id_user=$id";
} else {
    // Si la acción no es válida, mostramos un mensaje de error y detenemos la ejecución
    die("Acción no válida: " . $accion);
}

// Ejecutamos la consulta y verificamos si se realizó con éxito
if ($conn->query($sql) === TRUE) {
    echo "Acción realizada exitosamente"; // Mensaje de éxito
} else {
    // Si hubo un error, mostramos el mensaje de error
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerramos la conexión a la base de datos
$conn->close();

// Redirigimos al usuario de vuelta a la página principal después de la acción
header("Location: index.php");
exit(); // Terminamos el script
?>
