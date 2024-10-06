<?php
include("../config/Conexion.php");
$conexionDam = new Conexion();
$conexion = $conexionDam->conectar();

//Consulta para mostrar opciones select //
$sql = $conexion->query("SELECT * FROM tiposdocumentos");
$tipo_documento = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $conexion->query("SELECT * FROM estado_atencion");
$estadoatencion = $sql->fetchAll(PDO::FETCH_ASSOC);
$sql->execute();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h1 class="bg-black p-2 text-white text-center">agregar usuario</h1>

    <div class="container d-flex justify-content-center">
        <div class="col-12 col-md-6">
            <form action="../CRUD/insertarDatos.php" method="POST">
                <div class="row">
                    <div class="row g-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Nombres" name="nombres" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Apellidos" name="apellidos" required>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <select id="disabledSelect" name="tipoDeDocumento" class="form-select" required>
                                <option>Tipo de Documento</option>
                                <?php
                                foreach ($tipo_documento as $result) {
                                    echo "<option value='" . $result['id_tipoDocumento'] . "'>" . $result['glosa'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Documento" name="documento" required>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <select id="disabledSelect" name="estado" class="form-select" required>
                                <option>Estado</option>
                                <?php
                                foreach ($estadoatencion as $result) {
                                    echo "<option value='" . $result['id_estado'] . "'>" . $result['estado'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Edad" name="edad" required>
                        </div>
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
            </form>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>