<?php 
require_once 'Conexion.php';
require_once 'controladorLogin.php';
try{
    $db= new Conexion;
    $conexion = $db->conectar();
} catch (PDOException $ex) {
    $error = $ex->getMessage();
};

if (isset($_SESSION['usuario'])) {
    header('Location: bienvenidaCliente.php');
    exit;
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
    <?php 

$consultaBungalows= $conexion->query("SELECT * FROM ALOJAMIENTO"); 

while ($bungalow = $consultaBungalows->fetch(PDO::FETCH_ASSOC)) {

    echo "<a href='alojamiento.php?id=" . $bungalow['idAlojamiento'] . "'>" . $bungalow['tipo'] . "</a><br>";
} ?>

<br><br>
<h2>SERVICIOS</h2>
<?php 
$consultaServicios = $conexion->query("SELECT * FROM SERVICIO");

while ($servicio = $consultaServicios->fetch(PDO::FETCH_ASSOC)) {
    $nombreArchivo = strtolower(str_replace(' ', '_', $servicio['nombre'])) . ".html"; 
    echo "<a href='$nombreArchivo'>" . htmlspecialchars($servicio['descripcion']) . "</a><br>";
}
?>

</body>
</html>


