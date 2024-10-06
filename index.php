<?php
    require_once "conexion.php";

    $conexionDam = new Conexion();
    $conexion = $conexionDam->conectar();
    
    $sql = $conexion->prepare("
        SELECT * FROM tipodedocumentos
    ");
    $sql->execute();
    $tiposDocumentos = $sql->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <title>Formulario de Paciente</title>

    <style>
    .card {
        background-color: rgba(255, 255, 255, 0.8);
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
    }
    </style>

</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h2>Registro de Paciente</h2>
            </div>
            <div class="card-body">
                <form action="registro.php" method="post">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Completo:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipo_documento" class="form-label">Tipo de Documento:</label>
                        <select id="tipo_documento" name="tipo_documento" class="form-select" required>
                            <option value="">Seleccione</option>
                            <?php foreach ($tiposDocumentos as $tipoDocumento) { ?>
                            <option value="<?=$tipoDocumento['id_tipo_documento']?>"><?=$tipoDocumento['nombre_tipo']?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="numero_documento" class="form-label">Número de Documento:</label>
                        <input type="text" id="numero_documento" name="numero_documento" class="form-control" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
                <div lass="text-center  mt-3 d-grid">
                    <a href="visualizar.php">
                        <button type="submit" class="btn btn-primary">Visualizar Pacientes</button>
                    </a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>