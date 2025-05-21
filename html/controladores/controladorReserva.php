<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php'; 
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';
// Verifica si el usuario ha iniciado sesión; si no, termina la ejecución con un mensaje
if (!isset($_SESSION['usuario'])) {
    die("Debes iniciar sesión para realizar una reserva.");
}

// Recoger los datos enviados por el formulario
$idUsuario = $_SESSION['idUsuario']; // ID del usuario desde la sesión
$idAlojamiento = filter_input(INPUT_POST, 'bungalow', FILTER_SANITIZE_NUMBER_INT);
$fechaEntrada = filter_input(INPUT_POST, 'fechaInicio', FILTER_SANITIZE_SPECIAL_CHARS); 
$fechaSalida = filter_input(INPUT_POST, 'fechaFin', FILTER_SANITIZE_SPECIAL_CHARS);

$fechaActual= date('Y-m-d'); // Obtener la fecha actual
if ($fechaEntrada < $fechaActual) {
    setFlash("error", "La fecha de entrada debe ser posterior a la fecha actual.");
    header("Location: ../principal/reservar.php");
    exit;
}
// Se valida que no se pueda reservar en el pasado y que la fecha de salida sea después de la de entrada.
if ($fechaEntrada >= $fechaSalida) {
    setFlash("error", "La fecha de entrada debe ser anterior a la fecha de salida.");
    header("Location: ../principal/reservar.php");
    exit;
}

try{
    $db = new Conexion(); 
    $conexion = $db->conectar();
} catch (PDOException $ex) {
    setFlash("error", "Error de conexión: " . $ex->getMessage());
    header("Location: ../principal/reservar.php");
    exit;
} catch (Exception $ex) {
    setFlash("error", "Error inesperado: " . $ex->getMessage());
    header("Location: ../principal/reservar.php");
    exit;
}



// Verificar si hay alguna reserva que se solape con las fechas seleccionadas
$comprobarReservas = $conexion->prepare("
    SELECT * FROM RESERVA
    WHERE idAlojamiento = ? 
    AND (
        (fechaEntrada <= ? AND fechaSalida >= ?) OR  -- La reserva empieza dentro del rango
        (fechaEntrada <= ? AND fechaSalida >= ?) OR  -- La reserva termina dentro del rango
        (fechaEntrada >= ? AND fechaSalida <= ?)     -- La reserva está completamente dentro del rango
    )
");
$comprobarReservas->execute([$idAlojamiento, $fechaEntrada, $fechaEntrada, $fechaSalida, $fechaSalida, $fechaEntrada, $fechaSalida]);

$reservaExistente = $comprobarReservas->fetch(); 

if ($reservaExistente) {
    setFlash("error", "Este bungalow ya está reservado entre las fechas seleccionadas.");
    header("Location: ../principal/reservar.php");
    exit;
}


// Si no hay conflictos, insertar la nueva reserva
$insertarReserva = $conexion->prepare("
    INSERT INTO RESERVA (idUsuario, idAlojamiento, fechaEntrada, fechaSalida) 
    VALUES (?, ?, ?, ?)
");
$insertarReserva->execute([$idUsuario, $idAlojamiento, $fechaEntrada, $fechaSalida]);

setFlash("success", "¡Reserva confirmada del $fechaEntrada al $fechaSalida!");
header("Location: ../principal/reservar.php");
exit;


?>
