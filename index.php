<?php

require_once "config/Conexion.php";

$conexionDam = new Conexion();
$conexion = $conexionDam->conectar();

$sql = $conexion->query("SELECT * FROM pacientes
            INNER JOIN tiposdocumentos ON pacientes.id_tipoDocumento = tiposdocumentos.id_tipoDocumento
            INNER JOIN estado_atencion ON pacientes.id_estado = estado_atencion.id_estado ");

$pacientes = $sql->fetchAll(PDO::FETCH_ASSOC);
$sql->execute();

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
  <title>REGISTRO PACIENTES</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./styles/estilos.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
</head>

<body>
  <div class="container">
    <div class="row">
      <h2 class="text-center bg-dark text-white py-3">REGISTRO PACIENTES</h2>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#RegitroModal">
              Rgistrar Paciente
            </button>
            <hr>
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="RegistrosPacientes">
                <thead class="table-dark">
                  <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Documento</th>
                    <th>Tipo de Documento</th>
                    <th>Edad</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($pacientes as $paciente) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($paciente['nombres']) . "</td>";
                    echo "<td>" . htmlspecialchars($paciente['apellidos']) . "</td>";
                    echo "<td>" . htmlspecialchars($paciente['documento']) . "</td>";
                    echo "<td>" . htmlspecialchars($paciente['glosa']) . "</td>";
                    echo "<td>" . htmlspecialchars($paciente['edad']) . "</td>";
                    echo "<td>" . htmlspecialchars($paciente['estado']) . "</td>";
                    echo "<td><button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editModal' onclick='openEditModal(" . $paciente['id_paciente'] . ")'>Editar</button></td>";
                    //echo "<td><a href='CRUD/EliminarDatos.php?id_paciente=" . htmlspecialchars($paciente['id_paciente']) . "' class='btn btn-danger'>Eliminar</a></td>";
                    echo "<td><button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#eliminarModal' onclick='setEliminarHref(" . $paciente['id_paciente'] . ")'>Eliminar</button></td>";

                    echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal eliminar -->
  <div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="elimarModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm">
      <div class="modal-content text-center" style="background-color: rgba(255, 69, 58, 0.9); color: white; border-radius: 10px;">
        <div class="modal-header border-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white;"></button>
        </div>
        <div class="modal-body">
          <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z" />
            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
          </svg>
          <h4 class="mt-3">¿Está seguro de realizar esta acción?</h4>
        </div>
        <div class="modal-footer justify-content-center border-0">
          <form id="eliminarForm" action="./CRUD/EliminarDatos.php" method="POST">
            <input type="hidden" class="form-control" name="id" value="">
            <button type="submit" class="btn btn-light" style="background-color: white; color: red; border: none; padding: 10px 20px; border-radius: 5px;">Eliminar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de registro -->
  <div class="modal fade" id="RegitroModal" tabindex="-1" aria-labelledby="RegitroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="RegitroModalLabel">Registrar Paciente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="CRUD/insertarDatos.php" method="POST">
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Nombres" name="nombres" required>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Apellidos" name="apellidos" required>
              </div>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <select name="tipoDeDocumento" class="form-select" required>
                  <option>Tipo de Documento</option>
                  <?php
                  foreach ($tipo_documento as $result) {
                    echo "<option value='" . $result['id_tipoDocumento'] . "'>" . $result['glosa'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Documento" name="documento" required>
              </div>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-md-4">
                <select name="estado" class="form-select" required>
                  <option>Estado</option>
                  <?php
                  foreach ($estadoatencion as $result) {
                    echo "<option value='" . $result['id_estado'] . "'>" . $result['estado'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Edad" name="edad" required>
              </div>
              <div class="col-md-4">
                <button type="submit" class="btn btn-success w-100">Ingresar paciente</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal editar -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Editar Paciente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="./CRUD/EditarDatos.php" method="POST">
            <input type="hidden" class="form-control" name="idM" value="<?php echo isset($Datospaciente['id_paciente']) ? $Datospaciente['id_paciente'] : ''; ?>">
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Nombres" name="nombresM" value="<?php echo isset($Datospaciente['nombres']) ? $Datospaciente['nombres'] : ''; ?>" required>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Apellidos" name="apellidosM" value="<?php echo isset($Datospaciente['apellidos']) ? $Datospaciente['apellidos'] : ''; ?>" required>
              </div>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <select name="tipoDeDocumentoM" class="form-select" required>
                  <option>Tipo de Documento</option>
                  <?php
                  foreach ($tipo_documento as $result) {
                    if ($result['id_tipoDocumento'] == $Datospaciente['id_tipoDocumento']) {
                      echo "<option selected value='" . $result['id_tipoDocumento'] . "'>" . $result['glosa'] . "</option>";
                    } else {
                      echo "<option value='" . $result['id_tipoDocumento'] . "'>" . $result['glosa'] . "</option>";
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Documento" name="documentoM" value="<?php echo isset($Datospaciente['documento']) ? $Datospaciente['documento'] : ''; ?>" required>
              </div>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-md-4">
                <select name="estadoM" class="form-select" required>
                  <option>Estado</option>
                  <?php
                  foreach ($estadoatencion as $result) {
                    if ($result['id_estado'] == $Datospaciente['id_estado']) {
                      echo "<option selected value='" . $result['id_estado'] . "'>" . $result['estado'] . "</option>";
                    } else {
                      echo "<option value='" . $result['id_estado'] . "'>" . $result['estado'] . "</option>";
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Edad" name="edadM" value="<?php echo isset($Datospaciente['edad']) ? $Datospaciente['edad'] : ''; ?>" required>
              </div>
              <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Editar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
  <script src="validador.js"></script>
</body>

</html>