<?php
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';
$db = new Conexion();
$conexion = $db->conectar();

if (!isset($_SESSION['usuario'])) {
    header('Location: /../index.php');
    exit; // Detener la ejecución después de redirigir
}

if(filter_has_var(INPUT_POST, "cerrarSesion")){
    session_unset(); // Destruir todas las variables de sesión
    session_destroy();
    header('Location: /../index.php');
    exit; // Detener la ejecución después de redirigir
}

if(filter_has_var(INPUT_POST, "inicio")){
    header('Location: bienvenidaCliente.php');
    exit; // Detener la ejecución después de redirigir
}


$mensajeExito = getFlash("success");
$mensajeError = getFlash("error");

if ($mensajeExito) {
    echo "<p style='color: green;'>$mensajeExito</p>";
}
if ($mensajeError) {
    echo "<p style='color: red;'>$mensajeError</p>";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/../styles/styles.css">
    <title>Dar de baja un usuario</title>
</head>
<body>
        <div class="contenedor-global">
            <div class="container mt-4">

<form action="/../controladores/controladorDarDeBajaUsuario.php" method="POST">
<h1>Dar de baja un usuario</h1>
    <p>¿Estás seguro de que desea darse de baja?</p>
    <button type="submit" name="darDeBajaUsuario">Dar de baja</button>
</form>
    
    
<div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <button type="submit" name="inicio">Inicio</button>
        <br><br>
        <button type="submit" name="cerrarSesion">Cerrar sesión</button>
    </form>
</div>

 <footer class="bg-dark text-white text-center text-lg-start mt-5">
    <div class="container p-4">
        <div class="row">
            <!-- Información general -->
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Redes sociales</h5>
                <p>
                   <a href="https://www.instagram.com/ayuntamientotahal/" class="text-white">Instagram</a><br>
                   <a href="https://www.tiktok.com/search?q=ayuntamientotahal&t=1747319630493" class="text-white">TikTok</a><br>
                   <a href="https://www.facebook.com/ayuntamientotahal/" class="text-white">Facebook</a><br>

                </p>
            </div>

            
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Contacto</h5>
                <ul class="list-unstyled mb-0">
                    <li><i class="bi bi-envelope"></i> contacto@visitahal.es</li>
                    <li><i class="bi bi-telephone"></i> +34 123 456 789</li>
                    <li><i class="bi bi-geo-alt"></i> Tahal, Almería, España</li>
                </ul>
            </div>

            
            <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Ayuntamiento de Tahal</h5>
                   <a href="https://www.tahal.es/" class="text-white">Web del ayuntamiento</a><br>
                
            </div>
        </div>
    </div>

    <div class="text-center p-3 bg-secondary">
        © <?php echo date("Y"); ?> VisiTahal. Todos los derechos reservados.
    </div>
</footer>

</body>
</html>
