<?php
require_once 'Conexion.php';
require_once 'funcionesValidacion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "darDeBajaUsuario")) {
    $idUsuario= $_SESSION['idUsuario'];

    $errores = [];

    if (empty($idUsuario)) {
        $errores[] = "❌ Usuario no válido.";
    }

    try {
        $db = new Conexion();
        $conexion = $db->conectar();

        // Comprobar duplicado
        $consultaUsuario = $conexion->prepare("SELECT * FROM USUARIO WHERE idUsuario = :idUsuario");
        $consultaUsuario->bindParam(':idUsuario', $idUsuario);
        $consultaUsuario->execute();

        if ($consultaUsuario->rowCount() > 0 && empty($errores)) {
            $eliminarUsuario = $conexion->prepare("DELETE FROM USUARIO WHERE idUsuario = :idUsuario");
            $eliminarUsuario->bindParam(':idUsuario', $idUsuario);
            $eliminarUsuario->execute();
          


            setFlash("success", "✅ Usuario dado de baja con éxito.");
            session_destroy(); // Destruir la sesión del usuario dado de baja
        } else {
            $errores[] = "❌ El usuario no existe o ya ha sido dado de baja.";
            
        }

        
        // Redirigir a la vista de nuevo
        header("Location: index.php");
        exit;

    } catch (PDOException $ex) {
        setFlash("error", "❌ Error de conexión: " . $ex->getMessage());
        header("Location: darDeBajaUsuario.php");
        exit;
    }
}
