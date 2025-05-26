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

if (filter_has_var(INPUT_POST, "CRUDAdmin")) {
    header('Location: gestionarAdministradores.php');
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
    <title>Eliminar administradores</title>
    <link rel="stylesheet" href="/../styles/styles.css">
</head>
<body>
    <div class="contenedor-global">
        <h1>Eliminar un administrador</h1>

        <?php if ($flashSuccess): ?>
            <div style="color: green; font-weight: bold; text-align:center; margin-bottom: 20px;">
                <?= $flashSuccess ?>
            </div>
        <?php endif; ?>

        <?php if ($flashError): ?>
            <div style="color: red; font-weight: bold; text-align:center; margin-bottom: 20px;">
                <?= $flashError ?>
            </div>
        <?php endif; ?>

        <form action="/../controladores/controladorEliminarAdministrador.php" method="POST" class="formulario">
            <label>Usuarios administradores</label><br>
            <select name="id" required>
                <?php
                try {
                    $consultaAdministradores = $conexion->query("SELECT * FROM USUARIO WHERE idRol = 1");
                    while ($administrador = $consultaAdministradores->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($administrador['idUsuario']) . "'>" . htmlspecialchars($administrador['nombre']) . "</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option value=''>Error al cargar usuarios administradores</option>";
                }
                ?>
            </select>
            <br><br>
            <button type="submit" name="eliminarAdministrador" class="btn-purple">Eliminar administrador</button>
        </form>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="botones-container">
            <button type="submit" name="areaAdmin" class="btn-purple">Volver al área principal de administrador</button>
            <button type="submit" name="CRUDAdmin" class="btn-purple">CRUD Administradores</button>
            <button type="submit" name="cerrarSesion" class="btn-purple">Cerrar sesión</button>
        </form>
    </div>
</body>
</html>
