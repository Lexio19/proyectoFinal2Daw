<?php
session_start();
require_once 'Conexion.php';

if (!isset($_SESSION['usuario'])) {
    die("Debes iniciar sesión para realizar una reserva.");
}

// Recoger los datos enviados por el formulario
$idUsuario = $_SESSION['idUsuario'];
$idServicio = filter_input(INPUT_POST, 'servicio', FILTER_SANITIZE_NUMBER_INT);
$fechaContrata = filter_input(INPUT_POST, 'fechaContrata', FILTER_SANITIZE_SPECIAL_CHARS);

$fechaActual = date('Y-m-d');
if ($fechaContrata < $fechaActual) {
    die("La fecha de contratación debe ser posterior a la fecha actual.");
}

try {
    $db = new Conexion();
    $conexion = $db->conectar();
} catch (PDOException $ex) {
    die("Error de conexión: " . $ex->getMessage());
} catch (Exception $ex) {
    die("Error inesperado: " . $ex->getMessage());
}

// Consultamos la tabla SERVICIO para obtener el aforo y los días disponibles
$consultaTablaServicio = $conexion->prepare("SELECT diasServicio, aforo FROM SERVICIO WHERE idServicio = ?");
$consultaTablaServicio->execute([$idServicio]);
$servicio = $consultaTablaServicio->fetch(PDO::FETCH_ASSOC);

if (!$servicio) {
    die("Error: Servicio no encontrado.");
}

$diaDisponible = explode(",", strtolower($servicio['diasServicio']));
$aforo = $servicio['aforo'];

// Contamos las reservas que hay para el servicio y la fecha seleccionada
$consultaContrataciones = $conexion->prepare("SELECT COUNT(*) FROM CONTRATA WHERE idServicio = ? AND fechaContrata = ?");
$consultaContrataciones->execute([$idServicio, $fechaContrata]);
$numeroContrataciones = $consultaContrataciones->fetchColumn();

if ($numeroContrataciones >= $aforo) {
    die("No hay disponibilidad para el servicio seleccionado en la fecha indicada.");
}

// Obtener el día de la semana de la fecha seleccionada en inglés y en minúsculas
$diaSeleccionadoIngles = strtolower(date('l', strtotime($fechaContrata)));

// Aquí podrías añadir un array para traducir los días si en tu BD están en español
$traduccionDias = [
    'monday' => 'lunes',
    'tuesday' => 'martes',
    'wednesday' => 'miércoles',
    'thursday' => 'jueves',
    'friday' => 'viernes',
    'saturday' => 'sábado',
    'sunday' => 'domingo',
];

$diaSeleccionadoEspanol = $traduccionDias[$diaSeleccionadoIngles] ?? $diaSeleccionadoIngles;

if (!in_array($diaSeleccionadoEspanol, $diaDisponible)) {
    die("Error: Solo puedes reservar este servicio los días: " . implode(", ", $diaDisponible));
}

// Si no hay conflictos, insertar la nueva reserva
$insertarContratacion = $conexion->prepare("
    INSERT INTO CONTRATA (idServicio, idUsuario, fechaContrata)
    VALUES (?, ?, ?)
");
$insertarContratacion->execute([$idServicio, $idUsuario, $fechaContrata]);

echo "¡Reserva confirmada el $fechaContrata!";

?>
<div>
    <a href="index.php">Volver a la página de inicio</a>
</div>