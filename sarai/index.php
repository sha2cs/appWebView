<?php
require_once "Conexion.php";

$conexionDam = new Conexion();
$conexion = $conexionDam->conectar();

$sql = $conexion->prepare("
    SELECT * FROM usuarios INNER JOIN tipo_documentos ON usuarios.id_tipo_documento = tipo_documentos.id_tipo_documento");
$sql->execute();
$usuarios = $sql->fetchAll();
$sqlTipoDocumentos = $conexion->prepare("
    SELECT * FROM tipo_documentos");
$sqlTipoDocumentos->execute();
$tipo_documentos = $sqlTipoDocumentos->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Formulario</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modales Responsivos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex flex-col items-center p-4">

    <button onclick="abrirModal()" class="btn btn-success mb-4 w-full md:w-auto">
        Crear Usuario
    </button>

    <div class="md:px-32 py-8 w-full">
        <div class="shadow overflow-hidden rounded border-b border-gray-200">
            <!-- Añadido para hacer la tabla responsiva en pantallas pequeñas -->
            <div class="table-responsive">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nombre</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tipo Documento</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Número de documento</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php foreach ($usuarios as $usuario) { ?>
                            <tr>
                                <td class="text-left py-3 px-4"><?= $usuario['nombre'] ?></td>
                                <td class="text-left py-3 px-4"><?= $usuario['glosa'] ?></td>
                                <td class="text-left py-3 px-4"><?= $usuario['numero_de_documento'] ?></td>
                                <td class="text-left py-3 px-4">
                                    <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-700"
                                        onclick='abrirModal(<?= json_encode($usuario) ?>)'>Editar</button>
                                    <button class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-700"
                                        onclick='abrirModalBorrar(<?= json_encode($usuario) ?>)'>Eliminar</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Uno -->
    <div class="modal fade" id="modalOne" tabindex="-1" aria-labelledby="modalOneLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white rounded-lg shadow-lg">
                <div class="modal-header bg-red-500 text-white">
                    <h5 id="tituloModal" class="modal-title" id="modalOneLabel"> </h5>
                    <button type="button" class="btn-close" id="closeModalOneIcon" aria-label="Cerrar"></button>
                </div>
                <form id="modalOneForm" method="POST" action="funciones.php">
                    <input type="hidden" name="accion" id="accion">
                    <input type="hidden" name="id" id="idUsuario">

                    <div class="mb-3 px-4">
                        <label for="nombre" class="form-label text-gray-700">Ingrese el Nombre</label>
                        <input type="text" class="form-control w-full md:w-auto" id="nombre" name="nombre" placeholder="Escribe aquí">
                    </div>
                    <div class="mb-3 px-4">
                        <label for="tipoDocumento" class="form-label text-gray-700">Tipo de documento</label>
                        <select class="form-select w-full md:w-auto" id="tipoDocumento" name="tipoDocumento">
                            <option value="0">Selecciona documento</option>
                            <?php foreach ($tipo_documentos as $tipo_documento) { ?>
                                <option value="<?= $tipo_documento['id_tipo_documento'] ?>"><?= $tipo_documento['glosa'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3 px-4">
                        <label class="form-label text-gray-700">Número de Documento</label>
                        <input type="number" class="form-control w-full md:w-auto" id="numeroDocumento" name="numeroDocumento" placeholder="Escribe aquí">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" id="botonModalUno"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Dos -->
    <div class="modal fade" id="modalTwo" tabindex="-1" aria-labelledby="modalTwoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white rounded-lg shadow-lg">
                <div class="modal-header bg-blue-600 text-white">
                    <h5 class="modal-title" id="modalTwoLabel">Modal Dos</h5>
                    <button type="button" class="btn-close" id="closeModalTwoIcon" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-6 text-gray-700">
                    ¿Estás seguro de eliminar este usuario?
                </div>
                <div class="modal-footer">
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
                document.getElementById('nombre').value = usuario.nombre;
                document.getElementById('tipoDocumento').value = usuario.id_tipo_documento;
                document.getElementById('numeroDocumento').value = usuario.numero_de_documento;
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

        document.getElementById('closeModalOneIcon').addEventListener('click', function () {
            modalOne.hide();
        });

        function abrirModalBorrar(usuario) {
            document.getElementById('idUsuario').value = usuario.id_usuario;
            document.getElementById('accion').value = 'eliminar';
            modalTwo.show();
        }

        function eliminar() {
            document.getElementById('modalOneForm').submit();
        }

        document.getElementById('closeModalTwoIcon').addEventListener('click', function () {
            modalTwo.hide();
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

