<?php
    require_once "Conexion.php";

    $conexionDam = new Conexion();
    $conexion = $conexionDam->conectar();
    
    $sql = $conexion->prepare("
        SELECT * FROM pacientes INNER JOIN tipo_docs ON pacientes.id_tipo_doc = tipo_docs.id_tipo_doc
    ");
    $sql->execute();
    $pacientes = $sql->fetchAll();

    $sqlTipoDocs = $conexion->prepare("
        SELECT * FROM tipo_docs 
    ");
    $sqlTipoDocs->execute();
    $tipoDocs = $sqlTipoDocs->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<button onclick="abrirModal()" class="btn btn-primary" >
  Abrir Modal
</button>
<div class="container mt-5">
    <h1 class="text-2xl font-bold text-center mb-5 text-blue-700">Hospital Heberto</h1>
    <h2 class="text-2xl font-bold text-center mb-5 text-red-700"> "entra vivo y sale muerto" </h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered shadow-lg rounded-lg">
            <thead class="bg-blue-500 text-white text-center">
                <tr>
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Primer Apellido</th>
                    <th class="p-3">Segundo Apellido</th>
                    <th class="p-3">Fecha de nacimiento</th>
                    <th class="p-3">Fecha de ingreso</th>
                    <th class="p-3">Tipo documento</th>
                    <th class="p-3">Numero de documento</th>
                    <th class="p-3">Opciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php foreach ($pacientes as $paciente): ?>
                <tr class="bg-gray-100 hover:bg-gray-200 transition duration-300">
                    <td class="p-3"><?= $paciente['nombre'] ?></td>
                    <td class="p-3"><?= $paciente['apellido1'] ?></td>
                    <td class="p-3"><?= $paciente['apellido2'] ?></td>
                    <td class="p-3"><?= $paciente['fecha_nacimiento'] ?></td>
                    <td class="p-3"><?= $paciente['fecha_ingreso'] ?></td>
                    <td class="p-3"><?= $paciente['glosa'] ?></td>
                    <td class="p-3"><?= $paciente['numero_doc'] ?></td>
                    <td class="p-3">
                        <button onclick='abrirModal(<?= json_encode($paciente) ?>)' class="btn btn-primary">Editar</button>
                        <button onclick='abrirConfirmModal(<?= json_encode($paciente) ?>)' class="btn btn-danger">Eliminar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- Clase para un modal más grande -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="miModalLabel">Título del Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formuDat" method="POST" action="datosss.php">
        <input type="hidden" name="id" id="idPaciente">
        <input type="hidden" name="accion" id="accion">
        <div class="mb-3 px-4">
          <label class="form-label text-gray-700" for="nombre">Nombre</label>
          <input class="form-control" type="text" id="nombre" name="nombre">
        </div>
        <div class="mb-3 px-4">
          <label class="form-label text-gray-700" for="apellido1">Apellido Paterno</label>
          <input class="form-control" type="text" id="apellido1" name="apellido1">
        </div>
        <div class="mb-3 px-4">
          <label class="form-label text-gray-700" for="apellido2">Apellido Materno</label>
          <input class="form-control" type="text" id="apellido2" name="apellido2">
        </div>
        <div class="mb-3 px-4">
          <label class="form-label text-gray-700" for="fechaNac">Fecha de nacimiento</label>
          <input class="form-control" type="date" id="fechaNac" name="fechaNac">
        </div>
        <div class="mb-3 px-4">
          <label class="form-label text-gray-700" for="fechaIng">Fecha de Ingreso</label>
          <input class="form-control" type="date" id="fechaIng" name="fechaIng">
        </div>
        <div class="mb-3 px-4">
          <label class="form-label text-gray-700" for="tipoDoc">Tipo de Documento</label>
          <select class="form-control" name="tipoDoc" id="tipoDoc">
            <option value="0">Seleccione Tipo Documento</option>
            <?php foreach ($tipoDocs as $tipoDoc): ?>
            <option value="<?= $tipoDoc['id_tipo_doc'] ?>"><?= $tipoDoc['glosa'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3 px-4">
          <label class="form-label text-gray-700" for="numDoc">Numero de documento</label>
          <input class="form-control" type="number" id="numDoc" name="numDoc">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirmar acción</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button onclick="eliminar()" class="btn btn-danger" >Eliminar</button>
      </div>
    </div>
  </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  // Obtener el modal
  var modalElement = document.getElementById('miModal');
  var modal = new bootstrap.Modal(modalElement);

  var confirmModalElement = document.getElementById('confirmModal');
  var confirmModal = new bootstrap.Modal(confirmModalElement);


  // Para abrir el modal con JavaScript
  function abrirModal(paciente = null) {
    // Resetea el formulario antes de cualquier acción
    document.getElementById('formuDat').reset();

    if (paciente) {
        document.getElementById('idPaciente').value = paciente.id_doc;
        document.getElementById('nombre').value = paciente.nombre;
        document.getElementById('apellido1').value = paciente.apellido1;
        document.getElementById('apellido2').value = paciente.apellido2;
        document.getElementById('fechaNac').value = paciente.fecha_nacimiento;
        document.getElementById('fechaIng').value = paciente.fecha_ingreso;
        document.getElementById('tipoDoc').value = paciente.id_tipo_doc;
        document.getElementById('numDoc').value = paciente.numero_doc;
        document.getElementById('accion').value = 'editar';
    } else {
        // Asegúrate de que los campos ocultos se reseteen también
        document.getElementById('idPaciente').value = '';
        document.getElementById('accion').value = 'crear';
    }

    // Mostrar el modal
    modal.show();
  }

  // Para cerrar el modal con JavaScript
  function cerrarModal() {
    modal.hide();
  }
  function abrirConfirmModal(paciente) {
    document.getElementById('idPaciente').value = paciente.id_doc;
            document.getElementById('accion').value = 'eliminar';
    confirmModal.show();
  }
  function eliminar(){
            document.getElementById('formuDat').submit();
}
</script>

<!-- Botón que abre el modal con JavaScript -->
<script src="validador.js"></script>
</body>
</html>