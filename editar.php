<?php
require_once 'conexion.php';

// Verificar si se recibe un ID de usuario a editar
if (isset($_GET['id'])) {
    $conexionDB = new Conexion();
    $conexion = $conexionDB->conectar();

    $id_usuario = $_GET['id'];
    
    // Obtener el usuario de la base de datos
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        echo "Usuario no encontrado.";
        exit;
    }
} else {
    echo "No se ha especificado un ID de usuario.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Editar Usuario</h2>
    <form action="actualizar.php" method="post">
        <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario']; ?>">
        <label for="nombre">Nombre completo:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $usuario['nombre_usuario']; ?>" required><br><br>
        
        <label for="correo_electronico">Correo electrónico:</label>
        <input type="email" id="correo_electronico" name="correo_electronico" value="<?= $usuario['correo_electronico']; ?>" required><br><br>
        
        <label for="tipoDocumento">Tipo de documento:</label>
        <select name="tipoDocumento" id="tipoDocumento" required>
            <?php
           
            $sqlTipos = "SELECT * FROM TiposDocumentos";
            $stmtTipos = $conexion->query($sqlTipos);
            while ($tipo = $stmtTipos->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($tipo['id_tipoDocumento'] == $usuario['id_tipoDocumento']) ? "selected" : "";
                echo "<option value='{$tipo['id_tipoDocumento']}' $selected>{$tipo['nombreDocumento']}</option>";
            }
            ?>
        </select><br><br>

        <label for="numeroDocumento">Número de Documento:</label>
        <input type="text" id="numeroDocumento" name="numeroDocumento" value="<?= $usuario['numeroDocumento']; ?>" required><br><br>

        <button type="submit">Actualizar Usuario</button>
    </form>
</body>
</html>