<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}
if ((!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') && (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'superadministrador')) {
    header('Location: /../index.php');
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

// Mostrar mensajes flash
$flashSuccess = getFlash('success');
$flashError = getFlash('error');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear servicio</title>
    <link rel="stylesheet" href="/../styles/styles.css">
</head>
<body>
    <div class="contenedor-global">
        <h1>Crear nuevo servicio</h1>

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

        <form action="/../controladores/controladorCrearServicio.php" method="POST" enctype="multipart/form-data" class="formulario">
            <label for="nombre">Nombre</label><br>
            <input type="text" name="nombre" required><br><br>

            <label for="descripcion">Descripción</label><br>
            <textarea name="descripcion" rows="4" cols="50" required></textarea><br><br>

            <label for="aforo">Aforo</label><br>
            <input type="number" name="aforo" required><br><br>

            <label for="diaServicio">Día del servicio</label><br>
            <input type="text" name="diaServicio" required><br><br>

            <label for="imagen">Imagen del servicio</label><br>
            <input type="file" name="imagen" accept="image/*" required><br><br>

            <button type="submit" name="crearServicio" class="btn-purple">Crear servicio</button>
        </form>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="botones-container">
            <button type="submit" name="areaAdmin" class="btn-purple">Volver al área principal de administrador</button>
            <button type="submit" name="cerrarSesion" class="btn-purple">Cerrar sesión</button>
        </form>
    </div>
</body>
</html>
