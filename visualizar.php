<?php
require_once 'conexion.php';

$conexionDam = new Conexion();
$conexion = $conexionDam->conectar(); // Crea la conexión


$sql = "SELECT 
    u.nombre_usuario, 
    u.email, 
    u.id_tipo_documento, 
    u.numero_documento, 
    u.id_usuario, 
    td.nombre_tipo,
    td.codigo
FROM 
    usuarios u
JOIN 
    tipodedocumentos td ON u.id_tipo_documento = td.id_tipo_documento;
"; 

$resultado = $conexion -> query($sql);

echo "<style> 
    table {
        border-collapse: collapse;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    th, td {
        border: 1px solid #007BFF; /* Borde azul */
        padding: 12px;
        text-align: left;
    }
    th {
        background-color: #007BFF; /* Fondo azul para encabezados */
        color: white; /* Color de texto blanco */
    }
    tr:nth-child(even) {
        background-color: #f2f2f2; /* Fondo gris claro para filas pares */
    }
    tr:hover {
        background-color: #e7f3ff; /* Color de fondo azul claro al pasar el mouse */
    }
    a {
        color: #007BFF; /* Color de enlaces azul */
        text-decoration: none; /* Sin subrayado */
    }
    a:hover {
        text-decoration: underline; /* Subrayado al pasar el mouse */
    }
</style>";

if($resultado->rowCount() > 0) {
    echo "<table border = '1'>
            <tr>
                <th>NOMBRE USUARIO</th>
                <th>EMAIL</th>
                <th>TIPO DEL DOCUMENTO</th>
                <th>NÚMERO DE DOCUMENTO</th>
                <th>ACCIONES</th>
            </tr>"; 

    while($fila = $resultado->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>
                <td>".$fila['nombre_usuario']."</td>
                <td>".$fila['email']."</td>
                <td>".$fila['codigo']."</td>
                <td>".$fila['numero_documento']."</td>
                <td><a href='editar.php?id=".$fila['id_usuario']."'>Editar</a>,
                
                <a href='eliminar.php?id=".$fila['id_usuario']."'onclick=\" return confirm('Quiere eliminar a etse usuario?');\"> Eliminar</a></td>
                

            </tr>";
    }
    echo "</table>";
    
}else{

    echo "No hay registros encontrados.";
}

//include("visualizar.php");
    
?>


