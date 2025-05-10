<?php 
require_once 'controladorLogin.php';
require_once 'Conexion.php';
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
    <link rel="stylesheet" href="styles.css">
   
    <title>VisiTahal</title>
</head>
<body>
<!--Mensajes de éxito o error de setFlash()-->
    <?php if ($mensajeExito){?>
    <p style="color: green;"><?php echo htmlspecialchars($mensajeExito); ?></p>
<?php };
if ($mensajeError){ ?>
    <p style="color: red;"><?php echo htmlspecialchars($mensajeError); ?></p>
<?php }; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <h1>Bienvenidos a VisiTahal</h1>

    <img src="img/castilloTahal.jpg" alt="Castillo de Tahal">

    <div class="formulario">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label>Introduzca su email</label><br>
            <input type="text" name="email" value="<?php if (filter_has_var(INPUT_POST, "email")) echo filter_input(INPUT_POST, "email"); ?>"><br><br>

            <label>Introduzca la contraseña</label><br>
            <input type="text" name="password" value="<?php if (filter_has_var(INPUT_POST, "password")) echo filter_input(INPUT_POST, "password"); ?>"><br><br>

            <br><br>

            <button class="boton" type="submit" name="autenticarse">Iniciar sesión</button>
        </form>
    </div>

    <div class="registro">
        <h2>¿No tienes cuenta?</h2>
        <a href="registro.php">Regístrate</a>
    </div>

    <br><br>
    <h2>ALOJAMIENTOS</h2>

<div class="carrusel-contenedor">
    <div class="carrusel-track">
        <a href="alojamiento.html"><img src="img/bungalo1.jpg" alt="bungalo"></a>
        <a href="alojamiento.html"><img src="img/bungalo4.jpg" alt="bungalo"></a>
        <a href="alojamiento.html"><img src="img/bungalo2.jpg" alt="bungalo"></a>
        <a href="alojamiento.html"><img src="img/bungalo6.jpg" alt="bungalo"></a>
        <a href="alojamiento.html"><img src="img/bungalo3.jpg" alt="bungalo"></a>
        <a href="alojamiento.html"><img src="img/bungalo5.jpg" alt="bungalo"></a>
        <a href="alojamiento.html"><img src="img/bungalo1.jpg" alt="bungalo"></a>
        <a href="alojamiento.html"><img src="img/bungalo4.jpg" alt="bungalo"></a>
        <a href="alojamiento.html"><img src="img/bungalo2.jpg" alt="bungalo"></a>
        <a href="alojamiento.html"><img src="img/bungalo6.jpg" alt="bungalo"></a>
        <a href="alojamiento.html"><img src="img/bungalo3.jpg" alt="bungalo"></a>
        <a href="alojamiento.html"><img src="img/bungalo5.jpg" alt="bungalo"></a> 
    </div>
</div>


    <br><br>
    <h2>SERVICIOS</h2>

<div class="carrusel-contenedor">
    <div class="carrusel-track">
        <a href="servicios.html"><img src="img/almendros1.jpg" alt="servicio"></a>
        <a href="servicios.html"><img src="img/merendero2.jpg" alt="servicio"></a>
        <a href="servicios.html"><img src="img/muñecoNieve.jpg" alt="servicio"></a>
        <a href="servicios.html"><img src="img/castillo4.jpg" alt="servicio"></a>
        <a href="servicios.html"><img src="img/nieve6.jpg" alt="servicio"></a>
        <a href="servicios.html"><img src="img/pueblo1.jpg" alt="servicio"></a>
        <a href="servicios.html"><img src="img/tahal4.jpg" alt="servicio"></a>
        <a href="servicios.html"><img src="img/campo1.jpg" alt="servicio"></a>
        <a href="servicios.html"><img src="img/castillo3.jpg" alt="servicio"></a>
        <a href="servicios.html"><img src="img/tahal1.jpg" alt="servicio"></a>
        <a href="servicios.html"><img src="img/setas.webp" alt="servicio"></a>
        <a href="servicios.html"><img src="img/nieve4.jpg" alt="servicio"></a> 
        <a href="servicios.html"><img src="img/tahal3.jpg" alt="servicio"></a> 
        <a href="servicios.html"><img src="img/campo5.jpg" alt="servicio"></a> 
        <a href="servicios.html"><img src="img/almendros2.jpg" alt="servicio"></a>
        <a href="servicios.html"><img src="img/merendero5.jpg" alt="servicio"></a> 
        <a href="servicios.html"><img src="img/castillo5.jpg" alt="servicio"></a> 
        <a href="servicios.html"><img src="img/nieve6.jpg" alt="servicio"></a> 
        <a href="servicios.html"><img src="img/tahal3.jpg" alt="servicio"></a> 
        <a href="servicios.html"><img src="img/nieve2.jpg" alt="servicio"></a> 
        <a href="servicios.html"><img src="img/tahal5.jpg" alt="servicio"></a>  
    </div>
</div>

</body>
</html>
