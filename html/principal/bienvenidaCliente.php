<?php 
session_start(); // Iniciar la sesión al principio del script
ob_start(); // Iniciar el buffer de salida
//session_start(); La comento porque me salta el siguiente error:
//Notice: session_start(): Ignoring session_start() 
//because a session is already active in /var/www/html/controladorLogin.php on line 3
//Pero no lo entiendo porque me dijeron que había que ponerlo en todas las páginas
//porque es lo que habilita la sesión
require_once __DIR__ . '/../conexion/Conexion.php';
$nombreUsuario= $_SESSION['usuario'];
$idUsuario= $_SESSION['idUsuario'];
try{
    $db= new Conexion;
    $conexion = $db->conectar();
} catch (PDOException $ex) {
    $error = $ex->getMessage();
};
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: /../index.php');
    exit;
}

if(filter_has_var(INPUT_POST, "cerrarSesion")){
    session_unset(); // Destruir todas las variables de sesión
    session_destroy();
    header('Location: /../index.php');
    exit; // Detener la ejecución después de redirigir
}

if (!isset($_SESSION['usuario'])) {
    header('Location: /../index.php');
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

if (filter_has_var(INPUT_POST, "eliminarServicio")) {
    $idContrata = intval($_POST['idContrata']);
    $eliminar = $conexion->prepare("DELETE FROM CONTRATA WHERE idContrata = ?");
    $eliminar->bindParam(1, $idContrata, PDO::PARAM_INT);
    $eliminar->execute();
    if ($eliminar->execute()) {
        $mensajes[]= "Contratación eliminada con éxito.";
    } else {
        $mensajes[]= "Error al eliminar la reserva.";
    }
}

if(filter_has_var(INPUT_POST, "reservar")){
    header('Location: reservar.php');
    exit; // Detener la ejecución después de redirigir
}

if(filter_has_var(INPUT_POST, "contratar")){
    header('Location: contratar.php');
    exit; // Detener la ejecución después de redirigir
}

if(filter_has_var(INPUT_POST, "darDeBajaUsuario")){
    header('Location: darDeBajaUsuario.php');
    exit; // Detener la ejecución después de redirigir
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap 5.3 CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="/../styles/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Página principal de cliente</title>
</head>
<body>
    <div class="contenedor-global">
    <div class="container py-4">
    <h1>HOLA, CLIENTE <?php echo $nombreUsuario ?></h1>
    <h2>RESERVA DE ALOJAMIENTOS</h2>
    <div class="carrusel-contenedor">
    <div class="carrusel-track">
        <img src="/../img/bungalo1.jpg" alt="bungalo"></a>
        <img src="/../img/bungalo4.jpg" alt="bungalo"></a>
        <img src="/../img/bungalo2.jpg" alt="bungalo"></a>
        <img src="/../img/bungalo6.jpg" alt="bungalo"></a>
        <img src="/../img/bungalo3.jpg" alt="bungalo"></a>
        <img src="/../img/bungalo5.jpg" alt="bungalo"></a>
        <img src="/../img/bungalo1.jpg" alt="bungalo"></a>
        <img src="/../img/bungalo4.jpg" alt="bungalo"></a>
        <img src="/../img/bungalo2.jpg" alt="bungalo"></a>
        <img src="/../img/bungalo6.jpg" alt="bungalo"></a>
        <img src="/../img/bungalo3.jpg" alt="bungalo"></a>
        <img src="/../img/bungalo5.jpg" alt="bungalo"></a> 
    </div>
</div>
    <br><br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

    <button type="submit" name="reservar" class="btn btn-purple">Reservar un alojamiento</button>


</form>


<br><br>
<h2> CONTRATACIÓN DE SERVICIOS</h2>
<div class="carrusel-contenedor">
    <div class="carrusel-track">
        <img src="/../img/almendros1.jpg" alt="servicio"></a>
        <img src="/../img/merendero2.jpg" alt="servicio"></a>
        <img src="/../img/muñecoNieve.jpg" alt="servicio"></a>
        <img src="/../img/castillo4.jpg" alt="servicio"></a>
        <img src="/../img/nieve6.jpg" alt="servicio"></a>
        <img src="/../img/pueblo1.jpg" alt="servicio"></a>
        <img src="/../img/tahal4.jpg" alt="servicio"></a>
        <img src="/../img/campo1.jpg" alt="servicio"></a>
        <img src="/../img/castillo3.jpg" alt="servicio"></a>
        <img src="/../img/tahal1.jpg" alt="servicio"></a>
        <img src="/../img/setas.webp" alt="servicio"></a>
        <img src="/../img/nieve4.jpg" alt="servicio"></a> 
        <img src="/../img/tahal3.jpg" alt="servicio"></a> 
        <img src="/../img/campo5.jpg" alt="servicio"></a> 
        <img src="/../img/almendros2.jpg" alt="servicio"></a>
        <img src="/../img/merendero5.jpg" alt="servicio"></a> 
        <img src="/../img/castillo5.jpg" alt="servicio"></a> 
        <img src="/../img/nieve6.jpg" alt="servicio"></a> 
        <img src="/../img/tahal3.jpg" alt="servicio"></a> 
        <img src="/../img/nieve2.jpg" alt="servicio"></a> 
        <img src="/../img/tahal5.jpg" alt="servicio"></a>  
    </div>
</div>
 <br><br>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

<button type="submit" name="contratar" class="btn btn-purple">Contratar un servicio</button>


</form>
<br><br>

    <div>
    <br><br>
    <h2>Mis reservas</h2>
    <?php 
    $consultaReservas= $conexion->query("SELECT * FROM RESERVA WHERE idUsuario = '$idUsuario'");
    $consultaReservas->execute();
    // Verificar si el usuario tiene reservas
    if ($consultaReservas->rowCount() > 0) {
        echo "<ul>"; // Empezamos una lista desordenada
        while ($reserva = $consultaReservas->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>
                    <strong>Bungalow $reserva[idAlojamiento] :</strong> | 
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

<br><br>

<div>
    <br><br>
    <h2>Mis servicios contratados</h2>
    <?php 
    // Asegúrate de que $idUsuario esté definido correctamente antes de esta consulta
   $consultaServicios = $conexion->query("
    SELECT C.idContrata,C.fechaContrata, S.nombre AS nombreServicio, S.descripcion AS descripcionServicio, S.diasServicio 
    FROM SERVICIO S, CONTRATA C 
    WHERE S.idServicio = C.idServicio AND C.idUsuario = $idUsuario
");


    if ($consultaServicios->rowCount() > 0) {
        echo "<ul>";
        while ($servicio = $consultaServicios->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>";
            echo "<strong>{$servicio['nombreServicio']}</strong><br>";
            echo "{$servicio['descripcionServicio']}<br>";
            echo "<strong>Fecha contratada:</strong> {$servicio['fechaContrata']}<br>";
            echo "<strong>Día:</strong> {$servicio['diasServicio']}<br>";
            echo "
                <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST' style='display:inline; margin-top:5px;'>
                    <input type='hidden' name='idContrata' value='{$servicio['idContrata']}'>
                    <button type='submit' name='eliminarServicio'>Eliminar</button>
                </form>
            ";
            echo "</li><br>";
        }
        echo "</ul>";
    } else {
        echo "<p>No tienes servicios contratados en este momento.</p>";
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

    <button type="submit" name="cerrarSesion" class="btn btn-purple">Cerrar sesión</button>
    <button type="submit" name="darDeBajaUsuario" class="btn btn-purple">Darme de baja</button>


    </form>
    </div>
</div>
<footer class="bg-dark text-white text-center text-lg-start mt-5">
    <div class="container p-4">
        <div class="row">
            <!-- Información general -->
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Redes sociales</h5>
                <p>
                   <a href="https://www.instagram.com/ayuntamientotahal/" class="text-white">Instagram</a><br>
                   <a href="https://www.tiktok.com/search?q=ayuntamientotahal&t=1747319630493" class="text-white">TikTok</a><br>
                   <a href="https://www.facebook.com/ayuntamientotahal/" class="text-white">Facebook</a><br>

                </p>
            </div>

            
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Contacto</h5>
                <ul class="list-unstyled mb-0">
                    <li><i class="bi bi-envelope"></i> contacto@visitahal.es</li>
                    <li><i class="bi bi-telephone"></i> +34 123 456 789</li>
                    <li><i class="bi bi-geo-alt"></i> Tahal, Almería, España</li>
                </ul>
            </div>

            
            <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Ayuntamiento de Tahal</h5>
                   <a href="https://www.tahal.es/" class="text-white">Web del ayuntamiento</a><br>
                
            </div>
        </div>
    </div>

    <div class="text-center p-3 bg-secondary">
        © <?php echo date("Y"); ?> VisiTahal. Todos los derechos reservados.
    </div>
</footer>
</div>
</body>
</html>