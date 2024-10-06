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

echo '<style>

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-family: Arial, sans-serif;
    }
    

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    

    th {
        background-color: #4CAF50;
        color: white;
    }
    
    tr:hover {
        background-color: #f1f1f1;
    }
    
    a {
        color: #4CAF50;
        text-decoration: none;
    }
    
    a:hover {
        text-decoration: underline;
    }
</style>';


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
