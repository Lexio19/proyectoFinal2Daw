<?php
require_once 'Conexion.php';
require_once 'funcionesValidacion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "crearServicio")) {
    $nombre = filter_input(INPUT_POST, "nombre");
    $descripcion = filter_input(INPUT_POST, "descripcion");
    $aforo = filter_input(INPUT_POST, "aforo", FILTER_VALIDATE_INT);
    $diaServicio = filter_input(INPUT_POST, "diaServicio");
    
    $errores = [];

    if (empty($nombre)||empty($descripcion)) {
        $errores[] = "❌ Servicio no válido.";
    }

    try {
        $db = new Conexion();
        $conexion = $db->conectar();

        // Comprobar duplicado
        $consultaServicio = $conexion->prepare("SELECT * FROM SERVICIO WHERE nombre = :nombre");
        $consultaServicio->bindParam(':nombre', $nombre);
        $consultaServicio->execute();

        if ($consultaServicio->rowCount() > 0) {
            $errores[] = "❌ El servicio ya existe.";
        }

        if (empty($errores)) {
            $insertarServicio = $conexion->prepare("INSERT INTO SERVICIO (nombre, descripcion, aforo, diasServicio) VALUES (?,?,?,?)");
            $insertarServicio->bindParam(1, $nombre);
            $insertarServicio->bindParam(2, $descripcion);
            $insertarServicio->bindParam(3, $aforo);
            $insertarServicio->bindParam(4, $diaServicio);
            $insertarServicio->execute();

            setFlash("success", "✅ Servicio creado con éxito.");
        } else {
            setFlash("error", implode("<br>", $errores));
        }

        // Redirigir a la vista de nuevo
        header("Location: crearServicio.php");
        exit;

    } catch (PDOException $ex) {
        setFlash("error", "❌ Error de conexión: " . $ex->getMessage());
        header("Location: crearServicio.php");
        exit;
    }
}
