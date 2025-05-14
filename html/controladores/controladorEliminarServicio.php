<?php
require_once 'conexion/Conexion.php';
require_once 'funcionesValidacion.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "eliminarServicio")) {
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $errores = [];

    // Validación
    if (empty($id)) {
        $errores[] = "ID de servicio no válido.";
    }

    if (empty($errores)) {
        try {
            $db = new Conexion();
            $conexion = $db->conectar();
            
            // Preparar y ejecutar la consulta de eliminación
            $eliminarServicio = $conexion->prepare("DELETE FROM SERVICIO WHERE idServicio = :id");
            $eliminarServicio->bindParam(':id', $id, PDO::PARAM_INT);
            $eliminarServicio->execute();

            // Verificar si se eliminó alguna fila
            if ($eliminarServicio->rowCount() > 0) {
                setFlash("success", "Servicio eliminado con éxito.");
            } else {
                setFlash("error", "No se encontró el servicio.");
            }
        }catch (PDOException $ex) {
            if (str_contains($ex->getMessage(), '1451')) {
                setFlash('error', "No se puede eliminar este servicio porque tiene reservas asociadas.");
            } else {
                setFlash('error', "❌ Error inesperado: " . $ex->getMessage());
            }
        }
    } else {
        foreach ($errores as $error) {
            echo $error; // Muestra los errores si los hay
        }
    }

    // Redirigir de nuevo a la página de eliminación
    header('Location: eliminarServicio.php');
    exit; // Detener la ejecución después de redirigir
}
?>
