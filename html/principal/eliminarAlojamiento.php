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



if ((!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') && ($_SESSION['rol'] !== 'superadministrador')) {
    header('Location: /../index.php');
    exit;
}

if (filter_has_var(INPUT_POST, "areaAdmin")) {
    header('Location: areaAdmin.php');
    exit;
}


if (filter_has_var(INPUT_POST, "areaAlojamientos")) {
    header('Location: gestionarAlojamientos.php');
    exit;
}

if (filter_has_var(INPUT_POST, "cerrarSesion")) {
    session_unset();
    session_destroy();
    header('Location: /../index.php');
    exit;
}

$mensajeSuccess = getFlash('success');
$mensajeError = getFlash('error');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar alojamientos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap + estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/styles/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Eliminar un alojamiento</h1>

        <?php
if ($mensajeSuccess) {
    echo '<div class="alert alert-success">' . htmlspecialchars($mensajeSuccess) . '</div>';
}

if ($mensajeError) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($mensajeError) . '</div>';
}
?>


        <form action="/../controladores/controladorEliminarAlojamiento.php" method="POST" class="mb-4">
            <div class="mb-3">
                <label for="id" class="form-label">Alojamiento:</label>
                <select name="id" id="id" class="form-select" required>
                    <?php
                    try {
                        $consultaBungalows = $conexion->query("SELECT * FROM ALOJAMIENTO ORDER BY CAST(SUBSTRING_INDEX(tipo, ' ', -1) AS UNSIGNED)");
                        while ($bungalow = $consultaBungalows->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($bungalow['idAlojamiento']) . "'>" . htmlspecialchars($bungalow['tipo']) . "</option>";
                        }
                    } catch (PDOException $e) {
                        echo "<option value=''>Error al cargar alojamientos</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="eliminarAlojamiento" class="btn btn-danger">Eliminar alojamiento</button>
        </form>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="d-flex gap-2">
            <button type="submit" name="areaAlojamientos" class="btn btn-dark">Volver al área de alojamientos</button>
            <button type="submit" name="areaAdmin" class="btn btn-secondary">Volver al área principal de administrador</button>
            <button type="submit" name="cerrarSesion" class="btn btn-dark">Cerrar sesión</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
