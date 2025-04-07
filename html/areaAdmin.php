<?php
session_start();   

if(filter_has_var(INPUT_POST, "cerrarSesion")){
    session_unset(); // Destruir todas las variables de sesión
    session_destroy();
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}

if(filter_has_var(INPUT_POST, "gestionarAlojamientos")){
    header('Location: gestionarAlojamientos.php');
    exit; // Detener la ejecución después de redirigir
}

if(filter_has_var(INPUT_POST, "gestionarServicios")){
    header('Location: gestionarServicios.php');
    exit; // Detener la ejecución después de redirigir
}

if(filter_has_var(INPUT_POST, "crearNuevoAdministrador")){
    header('Location: crearNuevoAdministrador.php');
    exit; // Detener la ejecución después de redirigir
}


echo "BIENVENIDO A LA ZONA DE ADMINISTRADOR DE VisiTahal<br>";


?>
<br><br>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

<button type="submit" name="gestionarAlojamientos">Gestionar alojamientos</button>

<button type="submit" name="gestionarServicios">Gestionar servicios</button>

<button type="submit" name="crearNuevoAdministrador">Crear un nuevo administrador</button>

<button type="submit" name="cerrarSesion">Cerrar sesión</button>

</form>
</div>