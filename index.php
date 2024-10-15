<?php
require_once "Conexion.php";

$conexionDam = new Conexion();
$conexion = $conexionDam->conectar();

$sql = $conexion->prepare("
    SELECT * FROM usuarios  INNER JOIN tipo_documentos ON usuarios.id_tipo_documento = tipo_documentos.id_tipo_documento
    ");
$sql->execute();
$usuarios = $sql->fetchAll();
$sqlTiposDocumentos = $conexion->prepare("
    SELECT * FROM tipo_documentos
    ");
$sqlTiposDocumentos->execute();
$tipo_documentos = $sqlTiposDocumentos->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>modales</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <title>Modal con Bootstrap y Tailwind</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">
  <!-- Botón para abrir las modales -->
  <div class="container mt-5">
    <button onclick="abrirModal()" class="btn btn-success">
      Crear Usuario
    </button>
  </div>

  <!-- Tabla de datos -->
  <div class="container-fluid mx-auto mt-5">
    <div class="table-responsive">
      <table class="table table-striped table-bordered min-w-full bg-white">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100">Nombre</th>
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100">Tipo de Documento</th>
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100">Numero de Documento</th>
            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($usuarios as $usuario): ?>
            <tr>
              <td class="py-2 px-4 border-b border-gray-200 bg-white-100"><?= $usuario['name'] ?></td>
              <td class="py-2 px-4 border-b border-gray-200 bg-white-100"><?= $usuario['glosa'] ?></td>
              <td class="py-2 px-4 border-b border-gray-200 bg-white-100"><?= $usuario['numero_documento'] ?></td>
              <td class="py-2 px-4 border-b border-gray-200 bg-white-100">
                <button class="btn btn-primary" onclick='abrirModal(<?= json_encode($usuario) ?>)'>Editar</button>
                <button class="btn btn-danger" onclick='abrirModalBorrar(<?= json_encode($usuario) ?>)'>Eliminar</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Crear/Editar -->
  <div class="modal fade" id="modalOne" tabindex="-1" aria-labelledby="modalOneLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-white rounded-lg shadow-lg">
        <div class="modal-header bg-blue-500 text-white">
          <h5 id="tituloModal" class="modal-title"></h5>
          <button type="button" class="btn-close" id="closeModalOneIcon" aria-label="Cerrar"></button>
        </div>
        <form id="modalOneForm" method="POST" action="datos.php">
          <input type="hidden" name="accion" id="accion">
          <input type="hidden" name="id" id="idUsuario">

          <div class="modal-body">
            <div class="mb-3">
              <label for="nombre" class="form-label text-gray-700">Ingrese el Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe aquí">
            </div>
            <div class="mb-3">
              <label for="tipoDocumento" class="form-label text-gray-700">Tipo de documento</label>
              <select name="tipoDocumento" id="tipoDocumento" class="form-select">
                <option value="0">Seleccione tipo documento</option>
                <?php foreach ($tipo_documentos as $tipo_documento): ?>
                  <option value="<?= $tipo_documento['id_tipo_documento'] ?>"><?= $tipo_documento['glosa'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label text-gray-700">Numero de Documento</label>
              <input type="number" class="form-control" id="numeroDocumento" name="numeroDocumento" placeholder="Escribe aquí">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="closeModalOneFooterBtn">Cerrar</button>
            <button type="submit" class="btn btn-danger" id="botonModalUno"></button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Eliminar -->
  <div class="modal fade" id="modalTwo" tabindex="-1" aria-labelledby="modalTwoLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-white rounded-lg shadow-lg">
        <div class="modal-header bg-green-500 text-white">
          <h5 class="modal-title" id="modalTwoLabel">Confirmación</h5>
          <button type="button" class="btn-close" id="closeModalTwoIcon" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body p-6 text-gray-700">
          ¿Estás seguro de eliminar este usuario?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="closeModalTwoFooterBtn">Cerrar</button>
          <button onclick="eliminar()" class="btn btn-primary">Eliminar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const modalOneElement = document.getElementById('modalOne');
    const modalOne = new bootstrap.Modal(modalOneElement);

    const modalTwoElement = document.getElementById('modalTwo');
    const modalTwo = new bootstrap.Modal(modalTwoElement);

    function abrirModal(usuario = null) {
      if (usuario) {
        document.getElementById('tituloModal').innerText = 'Editar Usuario';
        document.getElementById('botonModalUno').innerText = 'Guardar';
        document.getElementById('idUsuario').value = usuario.id_usuario;
        document.getElementById('nombre').value = usuario.name;
        document.getElementById('tipoDocumento').value = usuario.id_tipo_documento;
        document.getElementById('numeroDocumento').value = usuario.numero_documento;
        document.getElementById('accion').value = 'editar';
      } else {
        document.getElementById('tituloModal').innerText = 'Crear Usuario';
        document.getElementById('botonModalUno').innerText = 'Crear';
        document.getElementById('modalOneForm').reset();
        document.getElementById('idUsuario').value = '';
        document.getElementById('accion').value = 'crear';
      }
      modalOne.show();
    }

    function abrirModalBorrar(usuario) {
      document.getElementById('idUsuario').value = usuario.id_usuario;
      document.getElementById('accion').value = 'eliminar';
      modalTwo.show();
    }

    function eliminar() {
      document.getElementById('modalOneForm').submit();
    }

    document.getElementById('closeModalOneFooterBtn').addEventListener('click', function() {
      modalOne.hide();
    });

    document.getElementById('closeModalOneIcon').addEventListener('click', function() {
      modalOne.hide();
    });

    document.getElementById('closeModalTwoFooterBtn').addEventListener('click', function() {
      modalTwo.hide();
    });

    document.getElementById('closeModalTwoIcon').addEventListener('click', function() {
      modalTwo.hide();
    });
  </script>
</body>

</html>
