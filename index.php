<?php
require_once "Conexion.php";

$conexionDam = new Conexion();
$conexion = $conexionDam->conectar();

$sql = $conexion->prepare("
    SELECT * FROM usuarios INNER JOIN tipos_documentos ON usuarios.id_tipo_documento = tipos_documentos.id_tipo_documento
");
$sql->execute();
$usuarios = $sql->fetchAll();
$sqlTiposDocumentos = $conexion->prepare("
    SELECT * FROM tipos_documentos
");
$sqlTiposDocumentos->execute();
$tipo_documentos = $sqlTiposDocumentos->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modales</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>


    <!-- Tabla de datos -->
    <div class="container mx-auto mt-5">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Nombre</th>
                        <th class="py-3 px-6 text-left">Tipo de Documento</th>
                        <th class="py-3 px-6 text-left">Número de Documento</th>
                        <th class="py-3 px-6 text-left">Opciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php foreach ($usuarios as $usuario): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6"><?= $usuario['nombre'] ?></td>
                        <td class="py-3 px-6"><?= $usuario['descripcion'] ?></td>
                        <td class="py-3 px-6"><?= $usuario['numero_documento'] ?></td>
                        <td class="py-3 px-6">
                            <button class="btn btn-primary" onclick='abrirModal(<?= json_encode($usuario) ?>)'>Editar</button>
                            <button class="btn btn-danger" onclick='abrirModalBorrar(<?= json_encode($usuario) ?>)'>Eliminar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Uno -->
    <div class="modal fade" id="modalOne" tabindex="-1" aria-labelledby="modalOneLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white rounded-lg shadow-lg">
                <div class="modal-header bg-red-500 text-white">
                    <h5 id="tituloModal" class="modal-title" id="modalOneLabel"></h5>
                    <button type="button" class="btn-close" id="closeModalOneIcon" aria-label="Cerrar"></button>
                </div>
                <form id="modalOneForm" method="POST" action="datos.php">
                    <input type="hidden" name="accion" id="accion">
                    <input type="hidden" name="id" id="idUsuario">

                    <div class="mb-3 px-4">
                        <label for="nombre" class="form-label text-gray-700" style="margin-top: 10px">Ingrese el Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe aquí">
                    </div>
                    <div class="mb-3 px-4">
                        <label for="tipoDocumento" class="form-label text-gray-700">Tipo de documento</label>
                        <select name="tipoDocumento" id="tipoDocumento" class="form-select">
                            <option value="0">Seleccione tipo de documento</option>
                            <?php foreach ($tipo_documentos as $tipo_documento): ?>
                                <option value="<?= $tipo_documento['id_tipo_documento'] ?>"><?= $tipo_documento['descripcion'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 px-4">
                        <label class="form-label text-gray-700">Número de Documento</label>
                        <input type="number" class="form-control" id="numeroDocumento" name="numeroDocumento" placeholder="Escribe aquí">
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
                <div class="modal-header bg-green-500 text-white">
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Inicializar la Modal Uno
        const modalOneElement = document.getElementById('modalOne');
        const modalOne = new bootstrap.Modal(modalOneElement);

        // Inicializar la Modal Dos
        const modalTwoElement = document.getElementById('modalTwo');
        const modalTwo = new bootstrap.Modal(modalTwoElement);

        // Botón para abrir la Modal Uno
        function abrirModal(usuario = null) {
            if (usuario) {
                document.getElementById('tituloModal').innerText = 'Editar Usuario';
                document.getElementById('botonModalUno').innerText = 'Guardar';
                document.getElementById('idUsuario').value = usuario.id_usuario;
                document.getElementById('nombre').value = usuario.nombre;
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

        // Ícono de cerrar en la cabecera de la Modal Uno
        document.getElementById('closeModalOneIcon').addEventListener('click', function () {
            modalOne.hide();
        });

        // Botón para abrir la Modal Dos
        function abrirModalBorrar(usuario) {
            document.getElementById('idUsuario').value = usuario.id_usuario;
            document.getElementById('accion').value = 'eliminar';
            modalTwo.show();
        }

        function eliminar() {
            document.getElementById('modalOneForm').submit();
        }

        // Ícono de cerrar en la cabecera de la Modal Dos
        document.getElementById('closeModalTwoIcon').addEventListener('click', function () {
            modalTwo.hide();
        });

        document.getElementById('modalOneForm').addEventListener('submit', function (event) {
            var tipoDocumento = document.getElementById('tipoDocumento').value;
            if (tipoDocumento == '0') {
                event.preventDefault();
                alert('Por favor, seleccione un tipo de documento válido.');
            }
        });
    </script>

    <!-- Botones para abrir las modales -->
    <button onclick="abrirModal()" class="btn btn-success" style="margin: 10px 0 0 71%;">
        Crear Usuario
    </button>
</body>

</html>
