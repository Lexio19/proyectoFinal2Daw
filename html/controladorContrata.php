<?php
session_start();
require_once 'Conexion.php'; // Asegúrate de incluir el archivo de conexión

if (!isset($_SESSION['usuario'])) {
    die("Debes iniciar sesión para realizar una reserva.");
}

// Recoger los datos enviados por el formulario
$idUsuario = $_SESSION['idUsuario']; // ID del usuario desde la sesión
$idServicio = filter_input(INPUT_POST, 'servicio', FILTER_SANITIZE_NUMBER_INT);
$fechaContrata = filter_input(INPUT_POST, 'fechaContrata', FILTER_SANITIZE_SPECIAL_CHARS); 


$fechaActual= date('Y-m-d'); // Obtener la fecha actual
if ($fechaContrata < $fechaActual) {
    die("La fecha de contratación debe ser posterior a la fecha actual.");
}

try{
    $db = new Conexion(); 
    $conexion = $db->conectar(); // Establecer la conexión correctamente
} catch (PDOException $ex) {
    die("Error de conexión: " . $ex->getMessage());
} catch (Exception $ex) {
    die("Error inesperado: " . $ex->getMessage());
}
//Consultamos la tabla SERVICIO para obtener el aforo y el día disponible
$consultaTablaServicio = $conexion->prepare("SELECT * FROM SERVICIO WHERE idServicio = ?");
$consultaTablaServicio->execute([$idServicio]);
$servicio = $consultaTablaServicio->fetch(PDO::FETCH_ASSOC);

$diaDisponible = $servicio['diaDisponible'];
$aforo = $servicio['aforo'];
//Contamos las reservas que hay para el servicio y la fecha seleccionada
$consultaReservas = $conexion->prepare("SELECT COUNT(*) FROM RESERVA WHERE idServicio = ? AND fechaContrata = ?");
$consultaReservas->execute([$idServicio, $fechaContrata]);
$numeroReservas = $consultaReservas->fetchColumn();
if ($numeroReservas >= $aforo) {
    die("No hay disponibilidad para el servicio seleccionado en la fecha indicada.");
}



?>
<div>   
        <a href="index.php">Volver a la página de inicio</a>
    </div>
