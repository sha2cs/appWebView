<?php
// Incluimos el archivo de conexión a la base de datos
require_once "Conexion.php";

// Creamos una nueva instancia de la clase de conexión y nos conectamos a la base de datos
$conexionDam = new Conexion();
$conexion = $conexionDam->conectar();

// Preparamos la consulta para obtener los usuarios y los tipos de documentos asociados mediante una unión (INNER JOIN)
$sql = $conexion->prepare("
    SELECT * FROM users INNER JOIN document_types ON users.id_document_type = document_types.id_document_type
    ");
$sql->execute(); // Ejecutamos la consulta
$users = $sql->fetchAll(); // Obtenemos todos los resultados de la consulta en un array

// Preparamos la consulta para obtener todos los tipos de documentos
$sqlDocuments = $conexion->prepare("
    SELECT * FROM document_types 
    ");
$sqlDocuments->execute(); // Ejecutamos la consulta
$document_Types = $sqlDocuments->fetchAll(); // Obtenemos todos los tipos de documentos en un array
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <!-- Incluimos Bootstrap CSS para estilos predefinidos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluimos Tailwind CSS para más personalización -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Script para incluir Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Estilos personalizados para botones, tablas y otros elementos visuales -->
    <style>
        body {
            background-color: #f3f4f6;
        }

        /* Estilos personalizados para los botones */
        .custom-button {
            background-color: #4f46e5;
            color: #fff;
            padding: 10px 20px;
            border-radius: 25px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Efecto hover para los botones */
        .custom-button:hover {
            background-color: #4338ca;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Estilos para la tabla y su contenedor */
        .table-container {
            margin-top: 2rem;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Estilos para la cabecera de la tabla */
        .table thead {
            background-color: #4f46e5;
            color: white;
        }

        /* Estilos para las filas alternadas de la tabla */
        .table tbody tr:nth-child(odd) {
            background-color: #f9fafb;
        }

        .table tbody tr:nth-child(even) {
            background-color: #eef2ff;
        }

        /* Estilos para las celdas de la tabla */
        .table td, .table th {
            padding: 1rem;
            text-align: center;
        }

        /* Estilos para la ventana modal */
        .modal-content {
            border-radius: 12px;
        }

        .modal-header {
            background-color: #4f46e5;
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        /* Estilos adicionales para los botones de acción (editar y eliminar) */
        .btn-danger, .btn-primary {
            border-radius: 25px;
        }

        /* Estilos para los campos de formulario */
        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        /* Estilos para las imágenes de los botones de acción */
        .action-btn img {
            width: 24px;
            height: 24px;
        }
    </style>
</head>

<body>

    <!-- Contenedor principal para el botón "Crear Usuario" -->
    <div class="container mt-5 text-center">
        <!-- Botón para abrir el modal de creación de usuario -->
        <button onclick="openModal()" class="custom-button">Crear Usuario</button>
    </div>

<!-- Contenedor principal para la tabla de usuarios -->
<div class="container table-container">
    <div class="table-responsive overflow-x-auto"> 
        <table class="table table-bordered table-striped">
            <!-- Encabezados de la tabla -->
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo de Documento</th>
                    <th>Número de Documento</th>
                    <th>Dirección</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Iteramos sobre la lista de usuarios y mostramos cada uno en una fila -->
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['description']) ?></td>
                        <td><?= htmlspecialchars($user['document_number']) ?></td>
                        <td><?= htmlspecialchars($user['address']) ?></td>
                        <td>
                            <!-- Botón de editar con ícono -->
                            <button class="action-btn" onclick='openModal(<?= json_encode($user) ?>)'>
                                <img src="https://img.icons8.com/ios-glyphs/30/000000/edit.png" alt="Editar">
                            </button>

                            <!-- Botón de eliminar con ícono -->
                            <button class="action-btn" onclick='eliminar(<?= json_encode($user) ?>)'>
                                <img src="https://img.icons8.com/ios-glyphs/30/000000/trash.png" alt="Eliminar">
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

    <!-- Ventana modal para crear/editar un usuario -->
    <div class="modal fade" id="modalOne" tabindex="-1" aria-labelledby="modalOneLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera de la ventana modal -->
                <div class="modal-header">
                    <h5 id="tituloModal" class="modal-title"></h5>
                    <button onclick="closeModal()" class="btn-close" aria-label="Cerrar"></button>
                </div>
                <!-- Formulario para crear o editar usuarios -->
                <form id="modalOneForm" method="POST" action="funciones.php">
                    <!-- Campos ocultos para determinar la acción y el ID del usuario -->
                    <input type="hidden" name="action" id="action">
                    <input type="hidden" name="id" id="idUsuario">

                    <!-- Campo para el nombre del usuario -->
                    <div class="mb-3 px-4">
                        <label for="name" class="form-label">Ingrese el Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Escriba aquí">
                    </div>

                    <!-- Campo para el tipo de documento del usuario -->
                    <div class="mb-3 px-4">
                        <label for="documenType" class="form-label">Tipo de Documento</label>
                        <select class="form-control" name="documenType" id="documenType">
                            <option value="0">Seleccione Tipo de Documento</option>
                            <!-- Iteramos sobre los tipos de documentos disponibles -->
                            <?php foreach ($document_Types as $document_Type) { ?>
                                <option value="<?= htmlspecialchars($document_Type['id_document_type']) ?>"><?= htmlspecialchars($document_Type['description']) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Campo para el número de documento -->
                    <div class="mb-3 px-4">
                        <label for="documentNumber" class="form-label">Número de Documento</label>
                        <input type="number" class="form-control" id="documentNumber" name="documentNumber" placeholder="Escriba aquí">
                    </div>

                    <!-- Campo para la dirección -->
                    <div class="mb-3 px-4">
                        <label for="address" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Escriba aquí">
                    </div>

                    <!-- Pie de la ventana modal con el botón de acción -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" id="botonForu"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap y lógica para abrir/cerrar modal y eliminar usuarios -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Inicializamos la instancia de la ventana modal
        const modalOneElement = document.getElementById('modalOne');
        const modalOne = new bootstrap.Modal(modalOneElement);

        // Función para abrir el modal, dependiendo de si se edita o crea un usuario
        function openModal(user=null) {
            document.getElementById('modalOneForm').reset(); // Limpiamos el formulario

            if (user){ // Si se pasa un usuario, significa que estamos editando
                document.getElementById('tituloModal').innerText = 'Editar Usuario';
                document.getElementById('action').value = 'editar';
                document.getElementById('idUsuario').value = user.id_user;
                document.getElementById('name').value = user.name;
                document.getElementById('documenType').value = user.id_document_type;
                document.getElementById('documentNumber').value = user.document_number;
                document.getElementById('address').value = user.address;
                document.getElementById('botonForu').innerText = 'Editar';
            } else { // Si no, estamos creando un nuevo usuario
                document.getElementById('tituloModal').innerText = 'Crear Usuario';
                document.getElementById('idUsuario').value = '';
                document.getElementById('action').value = 'crear';
                document.getElementById('botonForu').innerText = 'Crear';
            }
            modalOne.show(); // Mostramos el modal
        }

        // Función para cerrar el modal
        function closeModal() {
            modalOne.hide();
        }

        // Función para eliminar un usuario
        function eliminar(user){
            document.getElementById('idUsuario').value = user.id_user; // Asignamos el ID del usuario a eliminar
            document.getElementById('action').value = 'eliminar'; // Definimos la acción como 'eliminar'
            document.getElementById('modalOneForm').submit(); // Enviamos el formulario para eliminar
        }
    </script>
</body>

</html>
