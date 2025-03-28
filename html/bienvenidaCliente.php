<?php 
ob_start(); // Iniciar el buffer de salida
session_start();
require_once 'Conexion.php';
require_once 'controladorLogin.php';
$nombreUsuario= $_SESSION['usuario'];

if(filter_has_var(INPUT_POST, "cerrarSesion")){
    session_unset(); // Destruir todas las variables de sesión
    session_destroy();
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>HOLA, CLIENTE <?php echo $nombreUsuario ?></h1>

    <div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

    <button type="submit" name="cerrarSesion">Cerrar sesión</button>

    </form>
    </div>
    

    <h2>ALOJAMIENTOS</h2>
    <?php 

$consultaBungalows= $conexion->query("SELECT * FROM ALOJAMIENTO"); 

while ($bungalow = $consultaBungalows->fetch(PDO::FETCH_ASSOC)) {

    echo "<a href='alojamiento.php?id=" . $bungalow['idAlojamiento'] . "'>" . $bungalow['tipo'] . "</a><br>";
} ?>

<br><br>
<h2>SERVICIOS</h2>
<?php 
$consultaServicios=$conexion->query("SELECT * FROM SERVICIO");
 while ($servicio = $consultaServicios->fetch(PDO::FETCH_ASSOC)) {
    echo $servicio['descripcion'] . "<br>";
 } ?>

<br><br>
<div>   
        <a href="index.php">Volver a la página de inicio</a>
    </div>
</body>
</html>