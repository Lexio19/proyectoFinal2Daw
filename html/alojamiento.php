<?php
session_start();
require_once 'Conexion.php';

try {
    $db = new Conexion;
    $conexion = $db->conectar();
} catch (PDOException $ex) {
    die("Error de conexión: " . $ex->getMessage());
}

// Verificar si hay un ID en la URL
if (filter_has_var(INPUT_GET, 'id') && filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
    $idAlojamiento = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    // Obtener los datos del bungalow desde la base de datos
    $consulta = $conexion->prepare("SELECT * FROM ALOJAMIENTO WHERE idAlojamiento = ?");
    $consulta->bindParam(1, $idAlojamiento, PDO::PARAM_INT);
    $consulta->execute();
    $bungalow = $consulta->fetch(PDO::FETCH_ASSOC);

    if (!$bungalow) {
        die("El alojamiento no existe.");
    }
} else {
    die("ID de alojamiento no válido.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="styles.css">
    <title><?php echo htmlspecialchars($bungalow['tipo']); ?></title>
</head>
<body>

    <h1><?php echo htmlspecialchars($bungalow['tipo']); ?></h1>

    <img src="imagenes/alojamientos/<?php echo $bungalow['idAlojamiento']; ?>.jpg" 
         alt="<?php echo htmlspecialchars($bungalow['tipo']); ?>" 
         width="300px">

    <p><strong>Tipo:</strong> <?php echo htmlspecialchars($bungalow['tipo']); ?></p>
    <!--<p><strong>Capacidad:</strong> <?php echo htmlspecialchars($bungalow['capacidad']); ?> personas</p>
    <p><strong>Precio:</strong> <?php echo htmlspecialchars($bungalow['precio']); ?> € por noche</p> -->



    <?php if (isset($_SESSION['usuario'])){ ?>
        <form action="reservar.php" method="POST">
            <input type="hidden" name="idAlojamiento" value="<?php echo $bungalow['idAlojamiento']; ?>">
            <button type="submit">Reservar Bungaló</button>
        </form>
    <?php } else { ?>
        <p><a href="index.php">Inicia sesión</a> para reservar este bungaló.</p>
    <?php }; ?>
    <br><br>
    <a href="index.php">Volver a la página principal</a>

</body>
</html>











