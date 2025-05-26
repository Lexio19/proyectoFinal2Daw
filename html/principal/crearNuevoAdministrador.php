<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';



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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Crear nuevo administrador</title>
    <link rel="stylesheet" href="/../styles/styles.css" />
</head>
<body>
    <div class="contenedor-global">
        <?php
        if (isset($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $tipo => $mensaje) {
                echo "<div class='flash flash-$tipo'>" . htmlspecialchars($mensaje) . "</div>";
            }
            unset($_SESSION['flash']);
        }
        ?>

        <form action="/../controladores/controladorCrearNuevoAdministrador.php" method="POST" class="formulario">
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

            <button type="submit" name="crearAdministrador" class="btn-purple">Crear administrador</button>
        </form>

        <br><br>

        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="formulario">
            <button type="submit" name="CRUDAdmin" class="btn-purple">CRUD Administradores</button>
            <button type="submit" name="areaAdmin" class="btn-purple">Volver al área principal de administrador</button>
            <button type="submit" name="cerrarSesion" class="btn-purple">Cerrar sesión</button>
        </form>
    </div>
</body>
</html>
