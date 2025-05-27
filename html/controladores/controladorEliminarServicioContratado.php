<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';

if (!isset($_POST['idContrata'])) {
    setFlash('error', 'ID de contratación no proporcionado.');
    header('Location: /../principal/usuariosYReservas.php');
    exit;
}

$idContrata = $_POST['idContrata'];

try {
    $db = new Conexion();
    $conexion = $db->conectar();

    $consultaContratacion = $conexion->prepare("DELETE FROM CONTRATA WHERE idContrata = :id");
    $consultaContratacion->bindParam(':id', $idContrata);
    $consultaContratacion->execute();

    setFlash('success', 'Reserva eliminada correctamente.');
} catch (PDOException $e) {
    setFlash('error', 'Error al eliminar el servicio.');
}

header('Location: /../principal/usuariosYReservas.php');
exit;
