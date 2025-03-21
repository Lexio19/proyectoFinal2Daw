<?php 
require_once 'Conexion.php';

try{
    $db = new Conexion();
    $conexion = $db->conectar();
    //echo "Conexión exitosa";
    
} catch (PDOException $ex) {
    die("Error en la conexión $ex->getMessage");
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="styles.css">
    <script src="jquery.js"></script>
    <title>VisiTahal</title>
</head>
<body>

    <h1>Bienvenidos a VisiTahal</h1>

    <div class="formulario">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label>Introduzca su usuario</label><br>
            <input type="text" name="login" value="<?php if (filter_has_var(INPUT_POST, "login")) echo filter_input(INPUT_POST, "login"); ?>"><br><br>

            <label>Introduzca la contraseña</label><br>
            <input type="text" name="clave" value="<?php if (filter_has_var(INPUT_POST, "clave")) echo filter_input(INPUT_POST, "clave"); ?>"><br><br>

            <br><br>

            <button class="boton" type="submit" name="autenticarse">Iniciar sesión</button>
        </form>
    </div>

</body>
</html>


<?php 

$consultaBungalows= $conexion->query("SELECT * FROM ALOJAMIENTO");

while ($bungalow = $consultaBungalows->fetch(PDO::FETCH_ASSOC)) {
    echo $bungalow['tipo'] . "<br>";
}

?>