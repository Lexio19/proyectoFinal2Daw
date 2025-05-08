<?php

session_start();
require_once 'Conexion.php';
require_once 'funcionesValidacion.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}
if ((!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') && (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'superadministrador')) {
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
    <title>Crear servicio</title>
</head>
<body>
    <h1>Crear nuevo servicio</h1>
    <form action="controladorCrearServicio.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre" required><br><br>
        <label for="descripcion">Descripción</label><br>
        <textarea name="descripcion" rows="4" cols="50" required></textarea><br><br>
        <label for="aforo">Aforo</label><br>
        <input type="number" name="aforo" required><br><br>
        <label for="diaServicio">Día del servicio</label><br>
        <input type="text" name="diaServicio" required><br><br>
        <label for="imagen">Imagen del servicio</label><br>
    <input type="file" name="imagen" accept="image/*" required><br><br>

        <button type="submit" name="crearServicio">Crear servicio</button>
    </form>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <button type="submit" name="areaAdmin">Volver al área principal de administrador</button>
        <button type="submit" name="cerrarSesion">Cerrar sesión</button>
    </form>

</body>
</html>