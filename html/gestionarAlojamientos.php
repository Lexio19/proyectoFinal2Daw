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

if(filter_has_var(INPUT_POST, "crearAlojamiento")) {
    header('Location: crearAlojamiento.php');
    exit; // Detener la ejecución después de redirigir
}

if  (filter_has_var(INPUT_POST, "eliminarAlojamiento")) {
    header('Location: eliminarAlojamiento.php');
    exit; // Detener la ejecución después de redirigir
}


echo "Bienvenido a la zona para GESTIONAR los alojamientos<br>";
echo "Hay que añadir: eliminar alojamiento, modificar alojamiento, ver alojamientos<br>";
?>

<br><br>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
<button type="submit" name="crearAlojamiento">Crear alojamiento</button>
<br><br>
<button type="submit" name="eliminarAlojamiento">Eliminar alojamiento</button>

<br><br>


<button type="submit" name="areaAdmin">Volver al área principal de administrador</button>
<button type="submit" name="cerrarSesion">Cerrar sesión</button>


</form>