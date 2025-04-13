<?php

session_start();
require_once 'Conexion.php';
require_once 'funcionesValidacion.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}

if(filter_has_var(INPUT_POST, "areaAdmin")) {
    header('Location: areaAdmin.php');
    exit; // Detener la ejecución después de redirigir
}
if(filter_has_var(INPUT_POST, "cerrarSesion")) {
    session_unset(); // Destruir todas las variables de sesión
    session_destroy();
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear alojamiento</title>
</head>
<body>
    <h1>Crear nuevo alojamiento</h1>
    <form action="controladorCrearAlojamiento.php" method="POST">
        <label for="nombre">Tipo de alojamiento:</label><br>
        <input type="text" name="tipo" required><br><br>

        <button type="submit" name="crearAlojamiento">Crear alojamiento</button>
    </form>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <button type="submit" name="areaAdmin">Volver al área principal de administrador</button>
        <button type="submit" name="cerrarSesion">Cerrar sesión</button>
    </form>

</body>
</html>