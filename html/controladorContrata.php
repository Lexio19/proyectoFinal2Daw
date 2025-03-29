<?php
session_start();
require_once 'Conexion.php'; // Asegúrate de incluir el archivo de conexión

if (!isset($_SESSION['usuario'])) {
    die("Debes iniciar sesión para realizar una reserva.");
}

// Recoger los datos enviados por el formulario
$idUsuario = $_SESSION['idUsuario']; // ID del usuario desde la sesión
$idServicio = filter_input(INPUT_POST, 'servicio', FILTER_SANITIZE_NUMBER_INT);
$fechaContrata = filter_input(INPUT_POST, 'fechaContrata', FILTER_SANITIZE_SPECIAL_CHARS); // Reemplazado FILTER_SANITIZE_STRING


$fechaActual= date('Y-m-d'); // Obtener la fecha actual
if ($fechaContrata < $fechaActual) {
    die("La fecha de contratación debe ser posterior a la fecha actual.");
}

try{
    $db = new Conexion(); // Asegúrate de crear una instancia de la clase Conexion
    $conexion = $db->conectar(); // Establecer la conexión correctamente
} catch (PDOException $ex) {
    die("Error de conexión: " . $ex->getMessage());
} catch (Exception $ex) {
    die("Error inesperado: " . $ex->getMessage());
}


// Verificar si hay alguna reserva que se solape con las fechas seleccionadas
$comprobarServicios = $conexion->prepare("
    SELECT * FROM CONTRATA
    WHERE idServicio = ? 
    AND (
        (fechaEntrada <= ? AND fechaSalida >= ?) OR  -- La reserva empieza dentro del rango
        (fechaEntrada <= ? AND fechaSalida >= ?) OR  -- La reserva termina dentro del rango
        (fechaEntrada >= ? AND fechaSalida <= ?)     -- La reserva está completamente dentro del rango
    )
");
$comprobarReservas->execute([$idAlojamiento, $fechaEntrada, $fechaEntrada, $fechaSalida, $fechaSalida, $fechaEntrada, $fechaSalida]);

$reservaExistente = $comprobarReservas->fetch(); 

if ($reservaExistente) {
    die("Este bungalow ya está reservado entre las fechas seleccionadas.");
}

// Si no hay conflictos, insertar la nueva reserva
$insertarReserva = $conexion->prepare("
    INSERT INTO RESERVA (idUsuario, idAlojamiento, fechaEntrada, fechaSalida) 
    VALUES (?, ?, ?, ?)
");
$insertarReserva->execute([$idUsuario, $idAlojamiento, $fechaEntrada, $fechaSalida]);

echo "¡Reserva confirmada del $fechaEntrada al $fechaSalida!";


?>
<div>   
        <a href="index.php">Volver a la página de inicio</a>
    </div>
