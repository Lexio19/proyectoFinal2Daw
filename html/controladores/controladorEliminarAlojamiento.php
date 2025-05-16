<?php
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "eliminarAlojamiento")) {
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $errores = [];

    // Validación
    if (empty($id)) {
        $errores[] = "ID de alojamiento no válido.";
    }

    if (empty($errores)) {
        try {
            $db = new Conexion();
            $conexion = $db->conectar();
            
            // Preparar y ejecutar la consulta de eliminación
            $eliminarAlojamiento = $conexion->prepare("DELETE FROM ALOJAMIENTO WHERE idAlojamiento = :id");
            $eliminarAlojamiento->bindParam(':id', $id, PDO::PARAM_INT);
            $eliminarAlojamiento->execute();

            // Verificar si se eliminó alguna fila
            if ($eliminarAlojamiento->rowCount() > 0) {
                setFlash("success", "Alojamiento eliminado con éxito.");
            } else {
                setFlash("error", "No se encontró el alojamiento.");
            }
        }catch (PDOException $ex) {
            if (str_contains($ex->getMessage(), '1451')) {
                setFlash('error', "No se puede eliminar este alojamiento porque tiene reservas asociadas.");
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
    header('Location: ../eliminarAlojamiento.php');
    exit; // Detener la ejecución después de redirigir
}
?>
