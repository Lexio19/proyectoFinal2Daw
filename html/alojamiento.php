<?php 
session_start();
require_once 'Conexion.php';

try {
    $db = new Conexion;
    $conexion = $db->conectar();

    // Guardar en sesión si viene por POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idAlojamiento'])) {
        $_SESSION['idAlojamiento'] = intval($_POST['idAlojamiento']);
    }

    // Recuperar el ID desde la sesión
    if (isset($_SESSION['idAlojamiento'])) {
        $id = $_SESSION['idAlojamiento'];
        $consulta = $conexion->prepare("SELECT * FROM ALOJAMIENTO WHERE id = ?");
        $consulta->bindParam(1, $id, PDO::PARAM_INT);
        $consulta->execute();
        $alojamiento = $consulta->fetch(PDO::FETCH_ASSOC);

        if (!$alojamiento) {
            echo "Alojamiento no encontrado.";
            exit;
        }
    } else {
        echo "No se ha seleccionado un alojamiento.";
        exit;
    }
} catch (PDOException $ex) {
    echo "Error en la conexión: " . $ex->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title><?php echo htmlspecialchars($alojamiento['tipo']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($alojamiento['tipo']); ?></h1>
    <p>Descripción: <?php echo htmlspecialchars($alojamiento['descripcion']); ?></p>
    <p>Precio: <?php echo htmlspecialchars($alojamiento['precio']); ?> €</p>
    <p>Ubicación: <?php echo htmlspecialchars($alojamiento['ubicacion']); ?></p>

    <a href="index.php">Volver a la página principal</a>
</body>
</html>
