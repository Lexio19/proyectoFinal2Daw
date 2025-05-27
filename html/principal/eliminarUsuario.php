<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';
require_once __DIR__ . '/../controladores/controladorEliminarAlojamiento.php';

try {
    $db = new Conexion;
    $conexion = $db->conectar();
} catch (PDOException $ex) {
    $error = $ex->getMessage();
}



if ((!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') && (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'superadministrador')) {
    header('Location: /../index.php');
    exit;
}

if (filter_has_var(INPUT_POST, "areaAdmin")) {
    header('Location: areaAdmin.php');
    exit;
}

if (filter_has_var(INPUT_POST, "CRUDUsuarios")) {
    header('Location: gestionarUsuarios.php');
    exit;
}

if (filter_has_var(INPUT_POST, "cerrarSesion")) {
    session_unset();
    session_destroy();
    header('Location: /../index.php');
    exit;
}

// Mensajes flash
$flashSuccess = getFlash('success');
$flashError = getFlash('error');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar usuarios</title>
    <link rel="stylesheet" href="/../styles/styles.css">
</head>
<body>
    <div class="contenedor-global">
        <h1>Eliminar un usuario</h1>

        <?php
if ($flashSuccess) {
    echo '<div style="color: green; font-weight: bold; text-align:center; margin-bottom: 20px;">' . htmlspecialchars($flashSuccess) . '</div>';
}

if ($flashError) {
    echo '<div style="color: red; font-weight: bold; text-align:center; margin-bottom: 20px;">' . htmlspecialchars($flashError) . '</div>';
}
?>


        <form action="/../controladores/controladorEliminarUsuario.php" method="POST" class="formulario">
            <label>Usuarios clientes</label><br>
            <select name="id" required>
                <?php
                try {
                    $consultaAdministradores = $conexion->query("SELECT * FROM USUARIO WHERE idRol = 2");
                    while ($administrador = $consultaAdministradores->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($administrador['idUsuario']) . "'>" . htmlspecialchars($administrador['nombre']) . "</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option value=''>Error al cargar usuarios administradores</option>";
                }
                ?>
            </select>
            <br><br>
            <button type="submit" name="eliminarUsuario" class="btn-purple">Eliminar usuario</button>
        </form>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="botones-container">
            <button type="submit" name="CRUDUsuarios" class="btn-purple">CRUD Usuarios</button>
            <button type="submit" name="areaAdmin" class="btn-purple">Volver al área principal de administrador</button>
            <button type="submit" name="cerrarSesion" class="btn-purple">Cerrar sesión</button>
        </form>
    </div>
</body>
</html>
