<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';
// Verifica si se ha enviado el formulario con el botón 'darDeBajaUsuario'
if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "darDeBajaUsuario")) {
    $idUsuario = $_SESSION['idUsuario'] ?? null;

    $errores = [];

    if (empty($idUsuario)) {
        $errores[] = "❌ Usuario no válido.";
    }

    try {
        $db = new Conexion();
        $conexion = $db->conectar();
        // Consulta para comprobar si el usuario existe en la base de datos
        $consultaUsuario = $conexion->prepare("SELECT * FROM USUARIO WHERE idUsuario = :idUsuario");
        $consultaUsuario->bindParam(':idUsuario', $idUsuario);
        $consultaUsuario->execute();
        // Si el usuario existe y no hay errores, lo damos de baja
        if ($consultaUsuario->rowCount() > 0 && empty($errores)) {
            $eliminarUsuario = $conexion->prepare("DELETE FROM USUARIO WHERE idUsuario = :idUsuario");
            $eliminarUsuario->bindParam(':idUsuario', $idUsuario);
            $eliminarUsuario->execute();

            setFlash("success", "✅ Usuario dado de baja con éxito.");
            session_unset(); // Conserva $_SESSION['flash']
            header("Location: ../index.php");
            exit;
        } else {
            $errores[] = "❌ El usuario no existe o ya ha sido dado de baja.";
        }

        // Si hubo errores:
        if (!empty($errores)) {
            setFlash("error", "Errores:\n - " . implode("\n - ", $errores));
            header("Location: ../darDeBajaUsuario.php");
            exit;
        }

    } catch (PDOException $ex) {
        setFlash("error", "❌ Error de conexión: " . $ex->getMessage());
        header("Location: ../principal/darDeBajaUsuario.php");
        exit;
    }
}
