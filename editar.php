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
    $usuario = $stmt->fetch();
    
    $sql = $conexion->prepare("
        select * from tipodedocumentos
    ");
    $sql->execute();
    $tipodocumentos = $sql->fetchAll();
    
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <title>Editar Usuario</title>
</head>

<body>
    <div class="bg-responsive d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h2>Editar Usuario</h2>
                </div>
                <div class="card-body">
                    <form action="actualizar.php" method="post">
                        <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario']; ?>">

                        <div class="mb-3">
                            <label for="nombre_usuario" class="form-label">Nombre completo:</label>
                            <input type="text" id="nombre_usuario" name="nombre_usuario"
                                value="<?= $usuario['nombre_usuario']; ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico:</label>
                            <input type="email" id="email" name="email" value="<?= $usuario['email']; ?>"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_tipo_documento" class="form-label">Tipo de documento:</label>
                            <select name="id_tipo_documento" id="id_tipo_documento" class="form-select" required>
                                <?php foreach ($tipodocumentos as $row) { ?>
                                <option value="<?= $row['id_tipo_documento'] ?>"
                                    <?= $usuario['id_tipo_documento'] == $row['id_tipo_documento'] ? 'selected' : '' ?>>
                                    <?= $row['nombre_tipo'] ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="numero_documento" class="form-label">Número de Documento:</label>
                            <input type="text" id="numero_documento" name="numero_documento"
                                value="<?= $usuario['numero_documento']; ?>" class="form-control" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>