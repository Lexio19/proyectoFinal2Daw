<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
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

if(filter_has_var(INPUT_POST, "crearAlojamiento")) {
    header('Location: crearAlojamiento.php');
    exit; // Detener la ejecución después de redirigir
}

if  (filter_has_var(INPUT_POST, "eliminarAlojamiento")) {
    header('Location: eliminarAlojamiento.php');
    exit; // Detener la ejecución después de redirigir
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar alojamientos</title>
    <link rel="stylesheet" href="/../styles/styles.css"> 
</head>
<body>
<h1>Gestión de los alojamientos</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="botones-container">
    <button type="submit" name="crearAlojamiento" class="btn-purple">Crear alojamiento</button>
    <button type="submit" name="eliminarAlojamiento" class="btn-purple">Eliminar alojamiento</button>
    <button type="submit" name="areaAdmin" class="btn-purple">Volver al área principal de administrador</button>
    <button type="submit" name="cerrarSesion" class="btn-purple">Cerrar sesión</button>
</form>

</body>
</html>
