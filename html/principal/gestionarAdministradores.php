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

if (filter_has_var(INPUT_POST, "crearNuevoAdministrador")) {
    header('Location: crearNuevoAdministrador.php');
    exit;
}

if (filter_has_var(INPUT_POST, "eliminarAdministrador")) {
    header('Location: eliminarAdministrador.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CRUD Administradores</title>
    <link rel="stylesheet" href="/../styles/styles.css" />
</head>
<body>
    <div class="contenedor-global">
        <h2>Zona CRUD de administradores</h2>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="formulario">
            <div class="botones-container">
            <button type="submit" name="crearNuevoAdministrador" class="btn-purple">Crear nuevo administrador</button>
            <br><br>
            <button type="submit" name="eliminarAdministrador" class="btn-purple">Eliminar administrador</button>
            <br><br>
            <button type="submit" name="areaAdmin" class="btn-purple">Volver al área principal de administrador</button>
            <button type="submit" name="cerrarSesion" class="btn-purple">Cerrar sesión</button>
        </form>
    </div>
</body>
</html>
