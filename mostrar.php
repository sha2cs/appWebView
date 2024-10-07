<head>
    <style>
        table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-family: Arial, sans-serif;
}

th, td {
    border: 1px solid #007BFF; 
    padding: 10px;
    text-align: left;
}

th {
    background-color: #007BFF; 
    color: white; 
}

tbody tr:nth-child(even) {
    background-color: #e7f3ff; 
}

tbody tr:hover {
    background-color: #b3d7ff; 
}

a {
    color: #007BFF; 
    text-decoration: none; 
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>

<?php
require_once 'conexion.php';

$conexionDB = new Conexion();
$conexion = $conexionDB->conectar();

$sql = "
    SELECT u.id_usuario, u.nombre_usuario, u.correo_electronico, td.nombreDocumento, u.numeroDocumento 
    FROM usuarios u
    JOIN TiposDocumentos td ON u.id_tipoDocumento = td.id_tipoDocumento
";

$resultado = $conexion->query($sql);



if ($resultado->rowCount() > 0) {
    echo "<table border='1'>
            <tr>
                <th>NOMBRE USUARIO</th>
                <th>EMAIL</th>
                <th>TIPO DE DOCUMENTO</th>
                <th>NÚMERO DE DOCUMENTO</th>
                <th>ACCIONES</th>
            </tr>";

    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>".$fila['nombre_usuario']."</td>
                <td>".$fila['correo_electronico']."</td>
                <td>".$fila['nombreDocumento']."</td>
                <td>".$fila['numeroDocumento']."</td>
                <td>
                    <a href='editar.php?id=".$fila['id_usuario']."'>Editar</a> 
                    <a href='eliminar.php?id=".$fila['id_usuario']."' onclick=\"return confirm('¿Estás seguro de que deseas eliminar este usuario?');\">Eliminar</a> 
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros encontrados.";
}
?>