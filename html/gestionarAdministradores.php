<?php
session_start();
require_once 'Conexion.php';
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

if(filter_has_var(INPUT_POST, "crearNuevoAdministrador")) {
    header('Location: crearNuevoAdministrador.php');
    exit; // Detener la ejecución después de redirigir
}

if  (filter_has_var(INPUT_POST, "eliminarAdministrador")) {
    header('Location: eliminarAdministrador.php');
    exit; // Detener la ejecución después de redirigir
}



?>
<h2>Zona CRUD de administradores</h2>
<br><br>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
<button type="submit" name="crearNuevoAdministrador">Crear nuevo administrador</button>
<br><br>
<button type="submit" name="eliminarAdministrador">Eliminar administrador</button>

<br><br>


<button type="submit" name="areaAdmin">Volver al área principal de administrador</button>
<button type="submit" name="cerrarSesion">Cerrar sesión</button>


</form>