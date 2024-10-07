<?php
    require_once "Conexion.php";

    $conexionDam = new Conexion();
    $conexion = $conexionDam->conectar();
    
    $sql = $conexion->prepare("
        SELECT * FROM tipodocumento
    ");
    $sql->execute();
    $tipodocumento = $sql->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>

<div class="containerpt1">
<form action="validar.php" method="post">

    <h1>Registrar Paciente</h1>
    
    <label for="">Tipo de Documento: </label>
    <select name="tipodocumento" id="tipodocumento">
        <option value="0">Seleccione un tipo de documento</option>
    <?php
        foreach ($tipodocumento as $tipodocumento) {
    ?>
            <option value="<?=$tipodocumento['codigo']?>"><?=$tipodocumento['glosa']?></option>
    <?php
        }
    ?>
    </select> <br>

    <button type="submit">Validar</button> <br>
</form>
</div>

<div class="containerpt2">
<form action="registrar_usuario.php" method="post">

    <label for="nombres">Nombres: </label>
    <input type="text" name="nombres" id="nombres" required> <br></br>
    
    <label for="apellidos">Apellidos: </label>
    <input type="text" name="apellidos" id="apellidos" required> <br></br>

    <label for="tipodocumento">Tipo de documento</label>
     <select name="tipodocumento" id="tipodocumento">
        <option value="0">Seleccione...</option>
        <option value="TI">Tarjeta identidad</option>
        <option value="CC">Cédula ciudadanía</option>
        <option value="RC">Registro civil</option>
        <option value="CE">Cédula extranjería</option>
     </select> <br><br>
    
    <label for="ndoc">Número de documento: </label>
    <input type="text" name="ndoc" id="ndoc" required> <br></br>
   
    <label for="telefono">Teléfono: </label>
    <input type="text" name="telefono" id="telefono" required> <br></br>

    <label for="telefono">Correo electrónico: </label>
    <input type="email" name="correo" id="correo" required> <br></br>

    <button type="submit" name="registrar" value="registrar">Registrar</button>
    
    </div> 


    <?php
        $conn=mysqli_connect('localhost','admin','admin','dam')
    ?>

    <div class="tabla_usuarios">
    <div class="table-responsive">   
    <h2>Usuarios Registrados</h2>
        <table border=2>
                <tr>
                    <th>Id</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Tipo de documento</th>
                    <th>Número de documento</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th></th>
                    <th></th>
                    
                </tr>

                <?php
                   $ssql="SELECT * FROM usuarios";
                   $result=mysqli_query($conn,$ssql);

                   while($mostrar=mysqli_fetch_array($result)){
                ?>

                <tr>
                    <th> <?php echo $mostrar['id']?> </th>
                    <th> <?php echo $mostrar['nombres']?> </th>
                    <th> <?php echo $mostrar['apellidos']?> </th>
                    <th> <?php echo $mostrar['tipodocumento']?> </th>
                    <th> <?php echo $mostrar['ndoc']?> </th>
                    <th> <?php echo $mostrar['telefono']?> </th>
                    <th> <?php echo $mostrar['correo']?> </th>
                    <th> <a href="editar.php?id=<?php echo $mostrar['id']; ?>">Editar</a> </th>
                    <th> <a href="eliminar.php?id=<?php echo $mostrar['id']; ?>" onclick="return confirm('¿Deseas eliminar este registro?');">Eliminar</a> </th>
            
                    
                </tr>

                <?php
                    }
                ?>
                </table>

        </div>
        </div> 
    
</body>
</html>

</form>
</div>

<script src="validador.js"></script>

</body>
</html>