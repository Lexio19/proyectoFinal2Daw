<?php
require_once 'Conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "crearAlojamiento")) {
    $tipo = filter_input(INPUT_POST, "tipo");
    
    $errores = [];

    if (empty($tipo)) {
        $errores[] = "Tipo de alojamiento no válido<br>";
    }

    if (empty($errores)) {
        try {
            $db = new Conexion();
            $conexion = $db->conectar();
            
            $insertarAlojamiento = $conexion->prepare("INSERT INTO ALOJAMIENTO (tipo) VALUES (:tipo)");
            $insertarAlojamiento->bindParam(':tipo', $tipo);
            $insertarAlojamiento->execute();

            echo "Alojamiento creado con éxito.";
        } catch (PDOException $ex) {
            die("Error de conexión: " . $ex->getMessage());
        } catch (Exception $ex) {
            die("Error inesperado: " . $ex->getMessage());
        }
    } else {
        foreach ($errores as $error) {
            echo $error;
        }
    }
}
?>
