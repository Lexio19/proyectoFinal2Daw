<?php
require_once 'Conexion.php';

if (!isset($_GET['idServicio']) || !isset($_GET['fecha'])) {
    http_response_code(400);
    echo json_encode(["error" => "Faltan datos."]);
    exit;
}

$idServicio = intval($_GET['idServicio']);
$fecha = $_GET['fecha'];

try {
    $db = new Conexion();
    $conexion = $db->conectar();

    // Obtener aforo total
    $stmt = $conexion->prepare("SELECT aforo FROM SERVICIO WHERE idServicio = ?");
    $stmt->execute([$idServicio]);
    $aforo = $stmt->fetchColumn();

    if (!$aforo) {
        echo json_encode(["error" => "Servicio no encontrado."]);
        exit;
    }

    // Obtener número de reservas ya hechas
    $stmt = $conexion->prepare("SELECT COUNT(*) FROM CONTRATA WHERE idServicio = ? AND fechaContrata = ?");
    $stmt->execute([$idServicio, $fecha]);
    $ocupadas = $stmt->fetchColumn();

    $disponibles = $aforo - $ocupadas;
    echo json_encode(["disponibles" => $disponibles]);

} catch (Exception $e) {
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
}
?>
