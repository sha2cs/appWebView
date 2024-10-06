<?php
require_once "config/Conexion.php";

if (isset($_GET['id_paciente'])) {
    $id_paciente = $_GET['id_paciente'];

    // Crear una conexión a la base de datos
    $conexionDam = new Conexion();
    $conexion = $conexionDam->conectar();

    // Consulta para obtener los datos del paciente
    $sql = $conexion->prepare("SELECT * FROM pacientes 
                               INNER JOIN tiposdocumentos ON pacientes.id_tipoDocumento = tiposdocumentos.id_tipoDocumento
                               INNER JOIN estado_atencion ON pacientes.id_estado = estado_atencion.id_estado
                               WHERE id_paciente = :id_paciente");
    $sql->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
    $sql->execute();

    // Verificar si se encontró el paciente
    if ($sql->rowCount() > 0) {
        $paciente = $sql->fetch(PDO::FETCH_ASSOC);
        echo json_encode($paciente); // Enviar los datos como JSON
    } else {
        echo json_encode(['error' => 'No se encontró el paciente']);
    }
} else {
    echo json_encode(['error' => 'ID de paciente no proporcionado']);
}
?>