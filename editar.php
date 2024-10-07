<?php

    include 'Conexion.php';

$conexionDam = new Conexion();
$conn = $conexionDam->conectar();

    if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "Registro no encontrado";
        exit;
    }
}

if (isset($_POST['editar'])) {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $tipodocumento = $_POST['tipodocumento'];
    $ndoc = $_POST['ndoc'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    
    $query = "UPDATE usuarios SET nombres = :nombres, apellidos = :apellidos, tipodocumento = :tipodocumento, ndoc = :ndoc, telefono = :telefono, correo = :correo WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nombres', $nombres);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->bindParam(':tipodocumento', $tipodocumento);
    $stmt->bindParam(':ndoc', $ndoc);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="styledit.css">
</head>

<form method="POST">
    <h2>Editar Usuario</h2>

    <label for="nombres">Nombres:</label>
    <input type="text" name="nombres" value="<?php echo $row['nombres']; ?>" required><br><br>
    
    <label for="apellidos">Apellidos:</label>
    <input type="text" name="apellidos" value="<?php echo $row['apellidos']; ?>" required><br><br>
    
    <label for="tipodocumento">Tipo de documento:</label>
    <input type="text" name="tipodocumento" value="<?php echo $row['tipodocumento']; ?>" required><br><br>
    
    <label for="ndoc">Número de documento:</label>
    <input type="text" name="ndoc" value="<?php echo $row['ndoc']; ?>" required><br><br>
    
    <label for="telefono">Teléfono:</label>
    <input type="text" name="telefono" value="<?php echo $row['telefono']; ?>" required><br><br>
    
    <label for="correo">Correo:</label>
    <input type="email" name="correo" value="<?php echo $row['correo']; ?>" required><br><br>
    
    <button type="submit" name="editar">Actualizar</button>
</form>