$('#RegistrosPacientes').DataTable( {
    ordering: true,
    lengthChange: false,
    scrollY:250,
} )

function openEditModal(id_paciente) {
    fetch('getPaciente.php?id_paciente=' + id_paciente)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (!data.error) {
                document.querySelector('input[name="idM"]').value = data.id_paciente;
                document.querySelector('input[name="nombresM"]').value = data.nombres;
                document.querySelector('input[name="apellidosM"]').value = data.apellidos;
                document.querySelector('input[name="documentoM"]').value = data.documento;
                document.querySelector('input[name="edadM"]').value = data.edad;
                document.querySelector('select[name="tipoDeDocumentoM"]').value = data.id_tipoDocumento;
                document.querySelector('select[name="estadoM"]').value = data.id_estado;
            } else {
                console.error('Error:', data.error);
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}


function setEliminarHref(id_paciente) {
    const form = document.getElementById('eliminarForm');
    form.action = `./CRUD/EliminarDatos.php?id_paciente=${id_paciente}`;
  }