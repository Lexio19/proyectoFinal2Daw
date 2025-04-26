<?php
session_start();
require_once 'Conexion.php';
require_once 'funcionesValidacion.php';
$db = new Conexion();
$conexion = $db->conectar();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}

if(filter_has_var(INPUT_POST, "cerrarSesion")){
    session_unset(); // Destruir todas las variables de sesión
    session_destroy();
    header('Location: index.php');
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
    <title>Dar de baja un usuario</title>
</head>
<body>
<form action="controladorDarDeBajaUsuario.php" method="POST">
<h1>Dar de baja un usuario</h1>
    <p>¿Estás seguro de que deseas dar de baja a este usuario?</p>
    <button type="submit" name="darDeBajaUsuario">Dar de baja</button>
</form>
    
    
<div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <button type="submit" name="cerrarSesion">Cerrar sesión</button>
        <br><br>
    </form>
</div>






<div>   
    <a href="index.php">Volver a la página de inicio</a>
</div>
 
</body>
</html>
