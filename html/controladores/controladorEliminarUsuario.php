<?php
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "eliminarUsuario")) {
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $errores = [];

    // Validación
    if (empty($id)) {
        $errores[] = "ID de usuario no válido.";
    }
    
    if (empty($errores)) {
        try {
            $db = new Conexion();
            $conexion = $db->conectar();
            
            // Preparar y ejecutar la consulta de eliminación
            $eliminarCliente = $conexion->prepare("DELETE FROM USUARIO WHERE idUsuario = :id");
            $eliminarCliente->bindParam(':id', $id, PDO::PARAM_INT);
            $eliminarCliente->execute();

            // Verificar si se eliminó alguna fila
            if ($eliminarCliente->rowCount() > 0) {
                setFlash("success", "Usuario eliminado con éxito.");
            } else {
                setFlash("error", "No se encontró el administrador.");
            }
        }catch (PDOException $ex) {
            $errores[] = "❌ Error inesperado: " . $ex->getMessage();
        }
    } else {
        foreach ($errores as $error) {
            echo $error; // Muestra los errores si los hay
        }
    }

    // Redirigir de nuevo a la página de eliminación
    header('Location: ../principal/eliminarUsuario.php');
    exit; // Detener la ejecución después de redirigir
}
?>
