<?php
require_once 'conexion/Conexion.php';
require_once 'funcionesValidacion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "crearAlojamiento")) {
    $tipo = filter_input(INPUT_POST, "tipo");
    
    $errores = [];

    if (empty($tipo)) {
        $errores[] = "❌ Tipo de alojamiento no válido.";
    }

    try {
        $db = new Conexion();
        $conexion = $db->conectar();

        // Comprobar duplicado
        $consultaAlojamiento = $conexion->prepare("SELECT * FROM ALOJAMIENTO WHERE tipo = :tipo");
        $consultaAlojamiento->bindParam(':tipo', $tipo);
        $consultaAlojamiento->execute();

        if ($consultaAlojamiento->rowCount() > 0) {
            $errores[] = "❌ El tipo de alojamiento ya existe.";
        }

        if (empty($errores)) {
            $insertarAlojamiento = $conexion->prepare("INSERT INTO ALOJAMIENTO (tipo) VALUES (:tipo)");
            $insertarAlojamiento->bindParam(':tipo', $tipo);
            $insertarAlojamiento->execute();

            setFlash("success", "✅ Alojamiento creado con éxito.");
        } else {
            setFlash("error", implode("<br>", $errores));
        }

        // Redirigir a la vista de nuevo
        header("Location: crearAlojamiento.php");
        exit;

    } catch (PDOException $ex) {
        setFlash("error", "❌ Error de conexión: " . $ex->getMessage());
        header("Location: crearAlojamiento.php");
        exit;
    }
}
