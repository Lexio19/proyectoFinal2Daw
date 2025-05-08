<?php
session_start();
require_once 'Conexion.php';
require_once 'funcionesValidacion.php';
require_once 'controladorEliminarAlojamiento.php';
try {
    $db = new Conexion;
    $conexion = $db->conectar();
} catch (PDOException $ex) {
    $error = $ex->getMessage();
}
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}

if ((!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') && (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'superadministrador')) {
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}

if (filter_has_var(INPUT_POST, "areaAdmin")) {
    header('Location: areaAdmin.php');
    exit; // Detener la ejecución después de redirigir
}

if (filter_has_var(INPUT_POST, "cerrarSesion")) {
    session_unset(); // Destruir todas las variables de sesión
    session_destroy();
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}

// Mostrar mensajes flash (de éxito o error)
if ($mensaje = getFlash('success')) {
    echo "<div style='color: green; font-weight: bold;'>$mensaje</div>";
}

if ($mensaje = getFlash('error')) {
    echo "<div style='color: red; font-weight: bold;'>$mensaje</div>";
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
    <title>Eliminar administradores</title>
</head>
<body>
    <h1>Eliminar un administrador</h1>
    <form action="controladorEliminarAdministrador.php" method="POST">
        <label>Usuarios administradores</label><br>
        <select name="id" required>
    <?php
    try {
        $consultaAdministradores = $conexion->query("SELECT * FROM USUARIO WHERE idRol = 1");
        while ($administrador = $consultaAdministradores->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . htmlspecialchars($administrador['idUsuario']) . "'>" . htmlspecialchars($administrador['nombre']) . "</option>";
        }


        while ($administrador = $consultaAdministradores->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . htmlspecialchars($administrador['idUsuario']) . "'>" . htmlspecialchars($administrador['nombre']) . "</option>";
        }
    } catch (PDOException $e) {
        echo "<option value=''>Error al cargar usuarios administradores</option>";
    }
    ?>
</select>
        <br><br>
        <button type="submit" name="eliminarAdministrador">Eliminar administrador</button>
        
    </form>
    <br><br>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <button type="submit" name="areaAdmin">Volver al área principal de administrador</button>
        <button type="submit" name="cerrarSesion">Cerrar sesión</button>
    </form>

</body>
</html>

