<?php 
//Se incluyen los archivos necesarios para la conexión a la base de datos
//y las funciones de validación.
require_once __DIR__ . '/conexion/Conexion.php';
require_once __DIR__ . '/funcionesValidacion/funcionesValidacion.php';
//La conexión a la BBDD siempre la enmarcamos en un try-catch para evitar errores de conexión.
try {
    $db = new Conexion;
    $conexion = $db->conectar();
} catch (PDOException $ex) {
    $error = $ex->getMessage();
}
//Si la sesión está iniciada, directamente va a la página de bienvenidaCliente.php.
//Tenemos session_start() en controladorLogin.php, por eso no es necesario aquí.
if (isset($_SESSION['usuario'])) {
    header('Location: principal/bienvenidaCliente.php');
    exit;
}
//Declaramos los mensajes que mostrará getFlash tanto si es de éxito como de error.
$mensajeExito = getFlash("success");
$mensajeError = getFlash("error");
// Si hay sesión iniciada y no hay mensajes flash, redirige también a bienvenidaCliente.php
if (isset($_SESSION['usuario']) && !$mensajeExito && !$mensajeError) {
    header('Location: principal/bienvenidaCliente.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/styles/styles.css">
    <title>VisiTahal</title>
</head>
<body>
    
<div class="container mt-4">
    <!-- Muestra mensaje de éxito si existe -->
    <?php if ($mensajeExito): ?>
        <div class="alert alert-success text-center"><?php echo htmlspecialchars($mensajeExito); ?></div>
    <?php endif; ?>
    <!-- Muestra mensaje de error si existe -->
    <?php if ($mensajeError): ?>
        <div class="alert alert-danger text-center"><?php echo htmlspecialchars($mensajeError); ?></div>
    <?php endif; ?>
</div>

<div class="container text-center my-5">
    <h1>Bienvenidos a VisiTahal</h1>
    <img src="img/castilloTahal.jpg" class="img-fluid rounded shadow-sm mt-3" alt="Castillo de Tahal" style="max-height: 400px;">
</div>

<!-- Formulario de inicio de sesión -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 formulario">
            <form action="controladores/controladorLogin.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Introduzca su email</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="<?php if (filter_has_var(INPUT_POST, 'email')) echo filter_input(INPUT_POST, 'email'); ?>">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Introduzca la contraseña</label>
                    <input type="password" class="form-control" id="password" name="password"
                           value="<?php if (filter_has_var(INPUT_POST, 'password')) echo filter_input(INPUT_POST, 'password'); ?>">
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-purple" type="submit" name="autenticarse">Iniciar sesión</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Enlace para registrarse si no se tiene cuenta -->
<div class="container registro">
    <h2>¿No tienes cuenta?</h2>
    <a href="/principal/registro.php" class="btn btn-outline-dark mt-2">Regístrate</a>
</div>

<div class="container mt-5">
    <h2>ALOJAMIENTOS</h2>
    <div class="overflow-hidden p-3 bg-white rounded shadow-sm">
        <div class="carrusel-track">
            <?php
            $imagenesAlojamiento = [
                "bungalo1.jpg", "bungalo4.jpg", "bungalo2.jpg", "bungalo6.jpg", "bungalo3.jpg", "bungalo5.jpg"
            ];
            for ($i = 0; $i < 2; $i++) {
                foreach ($imagenesAlojamiento as $img) {
                    echo '<a href="html/alojamiento.html"><img src="img/' . $img . '" alt="bungalo"></a>';
                }
            }
            ?>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h2>SERVICIOS</h2>
    <div class="overflow-hidden p-3 bg-white rounded shadow-sm">
        <div class="carrusel-track">
            <?php
            $imagenesServicios = [
                "almendros1.jpg", "merendero2.jpg", "muñecoNieve.jpg", "castillo4.jpg", "nieve6.jpg", "pueblo1.jpg",
                "tahal4.jpg", "campo1.jpg", "castillo3.jpg", "tahal1.jpg", "setas.webp", "nieve4.jpg",
                "tahal3.jpg", "campo5.jpg", "almendros2.jpg", "merendero5.jpg", "castillo5.jpg", "nieve6.jpg",
                "tahal3.jpg", "nieve2.jpg", "tahal5.jpg"
            ];
            foreach ($imagenesServicios as $img) {
                echo '<a href="html/servicios.html"><img src="img/' . $img . '" alt="servicio"></a>';
            }
            ?>
        </div>
    </div>
</div>

<!-- Inclusión de JavaScript de Bootstrap y jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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