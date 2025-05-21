<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';

if (!isset($_SESSION['usuario'])) {
    die("Debes iniciar sesión para realizar una reserva.");
}

// Recoger los datos enviados por el formulario
$idUsuario = $_SESSION['idUsuario'];
$idServicio = filter_input(INPUT_POST, 'servicio', FILTER_SANITIZE_NUMBER_INT);
$fechaContrata = filter_input(INPUT_POST, 'fechaContrata', FILTER_SANITIZE_SPECIAL_CHARS);

$fechaActual = date('Y-m-d');
if ($fechaContrata < $fechaActual) {
    setFlash("error", "La fecha de contratación debe ser posterior a la fecha actual.");
    header('Location: ../principal/contratar.php');
    exit;
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
    setFlash("error", "Error: Servicio no encontrado.");
    header('Location: ../principal/contratar.php');
    exit;
}
// Convertir los días disponibles (string separado por comas) en un array en minúsculas
$diaDisponible = explode(",", strtolower($servicio['diasServicio']));
$aforo = $servicio['aforo']; // Obtener aforo máximo del servicio

// Contamos las reservas que hay para el servicio y la fecha seleccionada
$consultaContrataciones = $conexion->prepare("SELECT COUNT(*) FROM CONTRATA WHERE idServicio = ? AND fechaContrata = ?");
$consultaContrataciones->execute([$idServicio, $fechaContrata]);
$numeroContrataciones = $consultaContrataciones->fetchColumn();

if ($numeroContrataciones >= $aforo) {
    setFlash("error", "No hay disponibilidad para el servicio seleccionado en la fecha indicada.");
    header('Location: ../principal/contratar.php');
    exit;
}

// Obtener el día de la semana de la fecha seleccionada en inglés y en minúsculas
$diaSeleccionadoIngles = strtolower(date('l', strtotime($fechaContrata)));

//Traducimos los días al español, que es como están en mi BBDD.
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
    setFlash("error", "Error: Solo puedes reservar este servicio los días: " . implode(", ", $diaDisponible));
    header('Location: ../principal/contratar.php');
    exit;
}

// Si no hay conflictos, insertar la nueva reserva
$insertarContratacion = $conexion->prepare("
    INSERT INTO CONTRATA (idServicio, idUsuario, fechaContrata)
    VALUES (?, ?, ?)
");
$insertarContratacion->execute([$idServicio, $idUsuario, $fechaContrata]);
setFlash("success", "¡Reserva confirmada el $fechaContrata!");
header('Location: ../principal/contratar.php');
exit;

?>
