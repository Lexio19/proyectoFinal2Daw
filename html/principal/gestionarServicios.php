<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}
if ((!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') && (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'superadministrador')) {
    header('Location: index.php');
    exit;
}

if (filter_has_var(INPUT_POST, "areaAdmin")) {
    header('Location: areaAdmin.php');
    exit;
}

if (filter_has_var(INPUT_POST, "cerrarSesion")) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}

if (filter_has_var(INPUT_POST, "crearServicio")) {
    header('Location: crearServicio.php');
    exit;
}

if (filter_has_var(INPUT_POST, "eliminarServicio")) {
    header('Location: eliminarServicio.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Servicios</title>
    <link rel="stylesheet" href="/../styles/styles.css">
</head>
<body>
    <div class="contenedor-global">
        <h1>Gestión de los servicios</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="botones-container">
            <button type="submit" name="crearServicio" class="btn-purple">Crear servicio</button>
            <button type="submit" name="eliminarServicio" class="btn-purple">Eliminar servicio</button>
            <button type="submit" name="areaAdmin" class="btn-purple">Volver al área principal de administrador</button>
            <button type="submit" name="cerrarSesion" class="btn-purple">Cerrar sesión</button>
        </form>
    </div>
</body>
</html>
