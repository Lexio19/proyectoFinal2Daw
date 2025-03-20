<?php 
require_once 'Conexion.php';


$db = new Conexion();
$conexion = $db->conectar();

if($conexion->connect_error){
    die("Error en la conexión $conexion->connect_error");
}else{
    echo "Conexión exitosa";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<!-- Importamos Bootstrap y JQuery-->
    <link rel="stylesheet" href="styles.css">
    <script src="jquery.js"></script>
</head>

<h1>Bienvenidos a VisiTahal</h1>

</html>
