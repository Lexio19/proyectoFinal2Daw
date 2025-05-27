<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';


try {
    $db = new Conexion;
    $conexion = $db->conectar();
} catch (PDOException $ex) {
    die("Error de conexión: " . $ex->getMessage());
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

$mensajeSuccess = getFlash('success');
$mensajeError = getFlash('error');

$usuarioSeleccionado = $_POST['idUsuario'] ?? null;

$usuarios = [];
$reservas = [];
$servicios = [];

try {
    $usuariosStmt = $conexion->prepare("SELECT idUsuario, nombre FROM USUARIO WHERE idRol = 2");
    $usuariosStmt->execute();
    $usuarios = $usuariosStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $usuarios = [];
}

if ($usuarioSeleccionado) {
    // RESERVAS ALOJAMIENTO
    $consultaReservas = $conexion->prepare("
        SELECT R.idReserva, R.fechaEntrada, R.fechaSalida, A.tipo 
        FROM RESERVA R
        INNER JOIN ALOJAMIENTO A ON R.idAlojamiento = A.idAlojamiento
        WHERE R.idUsuario = :idUsuario
    ");
    $consultaReservas->execute(['idUsuario' => $usuarioSeleccionado]);
    $reservas = $consultaReservas->fetchAll(PDO::FETCH_ASSOC);

    // CONTRATACIONES DE SERVICIO
    $consultaServicios = $conexion->prepare("
        SELECT C.idContrata, C.fechaContrata, S.nombre 
        FROM CONTRATA C
        INNER JOIN SERVICIO S ON C.idServicio = S.idServicio
        WHERE C.idUsuario = :idUsuario
    ");
    $consultaServicios->execute(['idUsuario' => $usuarioSeleccionado]);
    $servicios = $consultaServicios->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver reservas por usuario</title>
    <link rel="stylesheet" href="/../styles/styles.css">
</head>
<body>
<div class="contenedor-global">
<?php
if ($mensajeSuccess) {
    echo '<div class="alert alert-success">' . htmlspecialchars($mensajeSuccess) . '</div>';
}

if ($mensajeError) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($mensajeError) . '</div>';
}
?>


    <h1>Ver reservas de un usuario</h1>

    <form method="POST" class="formulario">
        <label>Selecciona un usuario:</label>
        <select name="idUsuario" required onchange="this.form.submit()">
            <option value="">-- Selecciona --</option>
            <?php foreach ($usuarios as $usuario) { ?>
                <option value="<?= $usuario['idUsuario'] ?>" <?= ($usuarioSeleccionado == $usuario['idUsuario']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($usuario['nombre']) ?>
                </option>
            <?php } ?>
        </select>
    </form>

    <?php if ($usuarioSeleccionado) { ?>
        <h2>Reservas de alojamiento</h2>
        <?php if ($reservas) { ?>
            <table>
                <tr>
                    <th>Alojamiento</th>
                    <th>Fecha entrada</th>
                    <th>Fecha salida</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($reservas as $reserva) { ?>
                    <tr>
                        <td><?= htmlspecialchars($reserva['tipo']) ?></td>
                        <td><?= $reserva['fechaEntrada'] ?></td>
                        <td><?= $reserva['fechaSalida'] ?></td>
                        <td>
                            <form action="/../controladores/controladorEliminarReserva.php" method="POST">
                                <input type="hidden" name="idReserva" value="<?= $reserva['idReserva'] ?>">
                                <button type="submit" class="btn-purple">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No hay reservas de alojamiento.</p>
        <?php } ?>

        <h2>Contrataciones de servicios</h2>
        <?php if ($servicios) { ?>
            <table>
                <tr>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($servicios as $servicio) { ?>
                    <tr>
                        <td><?= htmlspecialchars($servicio['nombre']) ?></td>
                        <td><?= $servicio['fechaContrata'] ?></td>
                        <td>
                            <form action="/../controladores/controladorEliminarServicioContratado.php" method="POST">
                                <input type="hidden" name="idContrata" value="<?= $servicio['idContrata'] ?>">
                                <button type="submit" class="btn-purple">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No hay contrataciones de servicio.</p>
        <?php } ?>
    <?php } ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="botones-container">
            <button type="submit" name="CRUDUsuarios" class="btn-purple">CRUD Usuarios</button>
            <button type="submit" name="areaAdmin" class="btn-purple">Volver al área principal de administrador</button>
            <button type="submit" name="cerrarSesion" class="btn-purple">Cerrar sesión</button>
        </form>
</div>
</body>
</html>
