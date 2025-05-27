<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';

if (!isset($_POST['idReserva'])) {
    setFlash('error', 'ID de reserva no proporcionado.');
    header('Location: /../principal/usuariosYReservas.php');
    exit;
}

$idReserva = $_POST['idReserva'];

try {
    $db = new Conexion();
    $conexion = $db->conectar();

    $consultaReserva = $conexion->prepare("DELETE FROM RESERVA WHERE idReserva = :id");
    $consultaReserva->bindParam(':id', $idReserva);
    $consultaReserva->execute();

    setFlash('success', 'Reserva eliminada correctamente.');
} catch (PDOException $e) {
    setFlash('error', 'Error al eliminar la reserva.');
}

header('Location: /../principal/usuariosYReservas.php');
exit;
