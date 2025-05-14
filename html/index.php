<?php 
require_once 'controladores/controladorLogin.php';
require_once 'conexion/Conexion.php';
require_once 'funcionesValidacion.php';
try {
    $db = new Conexion;
    $conexion = $db->conectar();
} catch (PDOException $ex) {
    $error = $ex->getMessage();
}
//Si la sesión está iniciada, directamente va a la página de bienvenidaCliente.php
//tenemos session_start() en controladorLogin.php
if (isset($_SESSION['usuario'])) {
    header('Location: bienvenidaCliente.php');
    exit;
}

$mensajeExito = getFlash("success");
$mensajeError = getFlash("error");

if (isset($_SESSION['usuario']) && !$mensajeExito && !$mensajeError) {
    header('Location: bienvenidaCliente.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>VisiTahal</title>
</head>
<body>

<div class="container mt-4">
    <?php if ($mensajeExito): ?>
        <div class="alert alert-success text-center"><?php echo htmlspecialchars($mensajeExito); ?></div>
    <?php endif; ?>
    <?php if ($mensajeError): ?>
        <div class="alert alert-danger text-center"><?php echo htmlspecialchars($mensajeError); ?></div>
    <?php endif; ?>
</div>

<div class="container text-center my-5">
    <h1>Bienvenidos a VisiTahal</h1>
    <img src="img/castilloTahal.jpg" class="img-fluid rounded shadow-sm mt-3" alt="Castillo de Tahal" style="max-height: 400px;">
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 formulario">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
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

<div class="container registro">
    <h2>¿No tienes cuenta?</h2>
    <a href="registro.php" class="btn btn-outline-dark mt-2">Regístrate</a>
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
                    echo '<a href="alojamiento.html"><img src="img/' . $img . '" alt="bungalo"></a>';
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
                echo '<a href="servicios.html"><img src="img/' . $img . '" alt="servicio"></a>';
            }
            ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>