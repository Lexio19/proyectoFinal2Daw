<?php
session_start();   
if(filter_has_var(INPUT_POST, "cerrarSesion")){
    session_unset();
    session_destroy();
    header('Location: /../index.php');
    exit;
}
if (!isset($_SESSION['usuario'])) {
    header('Location: /../index.php');
    exit;
}

if ((!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') && (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'superadministrador')) {
    header('Location: /../index.php');
    exit;
}

if(filter_has_var(INPUT_POST, "gestionarAlojamientos")){
    header('Location: gestionarAlojamientos.php');
    exit;
}

if(filter_has_var(INPUT_POST, "gestionarServicios")){
    header('Location: gestionarServicios.php');
    exit;
}

if(filter_has_var(INPUT_POST, "gestionarAdministradores")){
    header('Location: gestionarAdministradores.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Zona de Administrador</title>
    <link rel="stylesheet" href="/../styles/styles.css"> 
</head>
<body>

    <div class="contenedor-global">
        <h1>Zona de Administrador</h1>
        <h2>Bienvenido a VisiTahal</h2>

        <div class="formulario" style="text-align:center;">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                
                <div class="botones-container">
    <button class="btn-purple" type="submit" name="gestionarAlojamientos">Gestionar alojamientos</button>
    <button class="btn-purple" type="submit" name="gestionarServicios">Gestionar servicios</button>
    <button class="btn-purple" type="submit" name="gestionarAdministradores">Gestionar administradores</button>
    <button class="btn-purple" type="submit" name="cerrarSesion">Cerrar sesión</button>
</div>


            </form>
        </div>
    </div>

</body>
</html>
