<?php 
session_start();
require_once 'Conexion.php';
require_once 'controladorLogin.php';
$nombreUsuario= $_SESSION['usuario'];


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
        <a href="index.php">Volver a la página de inicio</a>
    </div>
</body>
</html>