<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}
if ((!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') && (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'superadministrador')) {
    header('Location: /../index.php');
    exit;
}

if(filter_has_var(INPUT_POST, "areaAdmin")) {
    header('Location: areaAdmin.php');
    exit;
}

if(filter_has_var(INPUT_POST, "areaAlojamientos")) {
    header('Location: gestionarAlojamientos.php');
    exit;
}
if(filter_has_var(INPUT_POST, "cerrarSesion")) {
    session_unset();
    session_destroy();
    header('Location: /../index.php');
    exit;
}

// Mostrar mensajes flash
if ($mensaje = getFlash('success')) {
    echo "<div style='color: green; font-weight: bold;'>$mensaje</div>";
}
if ($mensaje = getFlash('error')) {
    echo "<div style='color: red; font-weight: bold;'>$mensaje</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../styles/styles.css">
    <title>Crear alojamiento</title>
</head>
<body>
    <h1>Crear nuevo alojamiento</h1>

    <form action="/../controladores/controladorCrearAlojamiento.php" method="POST" class="formulario">
        <label for="nombre">Tipo de alojamiento:</label><br>
        <input type="text" name="tipo" required><br><br>
        <button type="submit" name="crearAlojamiento" class="btn-purple">Crear alojamiento</button>
    </form>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="botones-container">
        <button type="submit" name="areaAlojamientos" class="btn-purple">Volver al área de alojamientos</button>
        <button type="submit" name="areaAdmin" class="btn-purple">Volver al área principal de administrador</button>
        <button type="submit" name="cerrarSesion" class="btn-purple">Cerrar sesión</button>
    </form>
</body>
</html>
