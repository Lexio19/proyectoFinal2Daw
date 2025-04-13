<?php
session_start();
require_once 'Conexion.php';
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

if(filter_has_var(INPUT_POST, "crearServicio")) {
    header('Location: crearServicio.php');
    exit; // Detener la ejecución después de redirigir
}

if  (filter_has_var(INPUT_POST, "eliminarServicio")) {
    header('Location: eliminarServicio.php');
    exit; // Detener la ejecución después de redirigir
}


echo "Bienvenido a la zona para GESTIONAR los SERVICIOS<br>";?>

<br><br>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
<button type="submit" name="crearServicio">Crear servicio</button>
<br><br>
<button type="submit" name="eliminarServicio">Eliminar servicio</button>

<br><br>


<button type="submit" name="areaAdmin">Volver al área principal de administrador</button>
<button type="submit" name="cerrarSesion">Cerrar sesión</button>


</form>