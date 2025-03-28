<?php 
ob_start(); // Iniciar el buffer de salida
//session_start(); La comento porque me salta el siguiente error:
//Notice: session_start(): Ignoring session_start() 
//because a session is already active in /var/www/html/controladorLogin.php on line 3
//Pero no lo entiendo porque me dijeron que había que ponerlo en todas las páginas
//porque es lo que habilita la sesión
require_once 'Conexion.php';
require_once 'controladorLogin.php';
$nombreUsuario= $_SESSION['usuario'];
$idUsuario= $_SESSION['idUsuario'];
try{
    $db= new Conexion;
    $conexion = $db->conectar();
} catch (PDOException $ex) {
    $error = $ex->getMessage();
};
if(filter_has_var(INPUT_POST, "cerrarSesion")){
    session_unset(); // Destruir todas las variables de sesión
    session_destroy();
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}

if (filter_has_var(INPUT_POST, "eliminarReserva")) {
    $idReserva = filter_input(INPUT_POST, 'idReserva', FILTER_SANITIZE_NUMBER_INT);
    $consultaEliminar = $conexion->prepare("DELETE FROM RESERVA WHERE idReserva = ? AND idUsuario = ?");
    $consultaEliminar->bindParam(1, $idReserva, PDO::PARAM_INT);
    $consultaEliminar->bindParam(2, $idUsuario, PDO::PARAM_INT);
    if ($consultaEliminar->execute()) {
        $mensajes[]= "Reserva eliminada con éxito.";
    } else {
        $mensajes[]= "Error al eliminar la reserva.";
    }
}

if(filter_has_var(INPUT_POST, "reservar")){
    header('Location: reservar.php');
    exit; // Detener la ejecución después de redirigir
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Página principal de cliente</title>
</head>
<body>
    <h1>HOLA, CLIENTE <?php echo $nombreUsuario ?></h1>

   
    

    <h2>RESERVA DE ALOJAMIENTOS</h2>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

    <button type="submit" name="reservar">Reservar</button>

</form>


<br><br>
<h2>SERVICIOS</h2>
<?php 
$consultaReservas= $conexion->query("SELECT * FROM RESERVA WHERE idUsuario = '$idUsuario'");
$consultaReservas->execute();
$consultaServicios=$conexion->query("SELECT * FROM SERVICIO");
 while ($servicio = $consultaServicios->fetch(PDO::FETCH_ASSOC)) {
    echo $servicio['descripcion'] . "<br>";
 } ?>

<br><br>


    <div>
    <br><br>
    <h2>Mis reservas</h2>
    <?php 
    // Verificar si el usuario tiene reservas
    if ($consultaReservas->rowCount() > 0) {
        echo "<ul>"; // Empezamos una lista desordenada
        while ($reserva = $consultaReservas->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>
                    <strong>Bungalow:</strong> | 
                    <strong>Fecha de entrada:</strong> " . $reserva['fechaEntrada'] . " | 
                    <strong>Fecha de salida:</strong> " . $reserva['fechaSalida'] . "
                    
                    <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST' style='display:inline; margin-left:10px;'>
                        <input type='hidden' name='idReserva' value='" . $reserva['idReserva'] . "'>
                        <button type='submit' name='eliminarReserva'>Eliminar</button>
                    </form>
                </li>";
        }
        echo "</ul>"; // Cerramos la lista
    } else {
        echo "No tienes reservas activas en este momento.";
    }
    ?>
</div>

<?php if (isset($mensajes)) {
    foreach ($mensajes as $mensaje) {
        echo "<p>$mensaje</p>";
    }
} ?>
<br><br>
<div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

    <button type="submit" name="cerrarSesion">Cerrar sesión</button>

    </form>
    </div>

</body>
</html>