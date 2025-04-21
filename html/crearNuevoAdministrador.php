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

if(filter_has_var(INPUT_POST, "CRUDAdmin")) {
    header('Location: gestionarAdministradores.php');
    exit; // Detener la ejecución después de redirigir
}

if(filter_has_var(INPUT_POST, "cerrarSesion")) {
    session_unset(); // Destruir todas las variables de sesión
    session_destroy();
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}




if (isset($_SESSION['flash'])) {
    foreach ($_SESSION['flash'] as $tipo => $message) {
        echo "<div class='flash flash-$tipo'>$message</div>";
    }
    unset($_SESSION['flash']);
}



?>

<br><br>
<form action="controladorCrearNuevoAdministrador.php" method="POST">
    <h2>Crear nuevo administrador</h2>

    <label for="dni">DNI</label><br>
    <input type="text" id="dni" name="dni" required><br><br>

    <label for="correoElectronico">Email</label><br>
    <input type="email" id="correoElectronico" name="correoElectronico" required><br><br>

    <label for="password">Contraseña</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <label for="nombre">Nombre</label><br>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <label for="apellidos">Apellidos</label><br>
    <input type="text" id="apellidos" name="apellidos" required><br><br>

    <label for="codigoPostal">Código Postal</label><br>
    <input type="text" id="codigoPostal" name="codigoPostal" required><br><br>

    <button type="submit" name="crearAdministrador">Crear administrador</button>
  
</form>
<br><br>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <button type="submit" name="CRUDAdmin">CRUD Administradores</button>
    <button type="submit" name="areaAdmin">Volver al área principal de administrador</button>
    <button type="submit" name="cerrarSesion">Cerrar sesión</button>
</form>
