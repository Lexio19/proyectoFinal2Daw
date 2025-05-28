<?php
session_start();
require_once __DIR__. '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';
require_once __DIR__. '/../controladores/controladorEliminarServicio.php';

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

if (filter_has_var(INPUT_POST, "areaServicios")) {
    header('Location: gestionarServicios.php');
    exit;
}

if (filter_has_var(INPUT_POST, "areaAdmin")) {
    header('Location: areaAdmin.php');
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Eliminar servicios</title>
    <link rel="stylesheet" href="/../styles/styles.css" />
</head>
<body>
    <div class="contenedor-global">
        <h1>Eliminar un servicio</h1>

        <?php
if ($flashSuccess) {
    echo '<div class="mensaje-exito">' . htmlspecialchars($flashSuccess) . '</div>';
}

if ($flashError) {
    echo '<div class="mensaje-error">' . htmlspecialchars($flashError) . '</div>';
}
?>


        <form action="/../controladores/controladorEliminarServicio.php" method="POST" class="formulario">
            <label for="servicio">Servicio:</label><br>
            <select name="id" id="servicio" required>
                <?php
                try {
                    $consultaServicios = $conexion->query("SELECT * FROM SERVICIO ORDER BY idServicio ASC");
                    while ($servicio = $consultaServicios->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($servicio['idServicio']) . "'>" . htmlspecialchars($servicio['descripcion']) . "</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option value=''>Error al cargar servicios</option>";
                }
                ?>
            </select>
            <br><br>
            <button type="submit" name="eliminarServicio" class="btn-purple">Eliminar servicio</button>
        </form>

        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="botones-container">
            <button type="submit" name="areaServicios" class="btn-purple">Volver al área de los servicios</button>
            <button type="submit" name="areaAdmin" class="btn-purple">Volver al área principal de administrador</button>
            <button type="submit" name="cerrarSesion" class="btn-purple">Cerrar sesión</button>
        </form>
    </div>
</body>
</html>
