<?php
require_once __DIR__ . '/../conexion/Conexion.php';
$db = new Conexion();
$conexion = $db->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];

    $consultaBungalowsNoReservados = "SELECT A.idAlojamiento, A.tipo 
        FROM ALOJAMIENTO A
        WHERE A.idAlojamiento NOT IN (
            SELECT R.idAlojamiento
            FROM RESERVA R
            WHERE :fechaInicio <= R.fechaSalida AND :fechaFin >= R.fechaEntrada
        ) ORDER BY A.tipo";

    $bungalowsNoReservados = $conexion->prepare($consultaBungalowsNoReservados);
    $bungalowsNoReservados->bindParam(':fechaInicio', $fechaInicio);
    $bungalowsNoReservados->bindParam(':fechaFin', $fechaFin);
    $bungalowsNoReservados->execute();


    $bungalowsDisponibles = $bungalowsNoReservados->fetchAll(PDO::FETCH_ASSOC);


    if ($bungalowsDisponibles) {
        foreach ($bungalowsDisponibles as $bungalow) {
            echo "<option value='" . $bungalow['idAlojamiento'] . "'>" . htmlspecialchars($bungalow['tipo']) . "</option>";
        }
    } else {
        echo "<option value=''>No hay bungalows disponibles</option>";
    }
}
?>