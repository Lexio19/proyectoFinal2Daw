<?php 
require_once 'Conexion.php';
require_once 'controladorLogin.php';
try {
    $db = new Conexion;
    $conexion = $db->conectar();
} catch (PDOException $ex) {
    $error = $ex->getMessage();
}

if (isset($_SESSION['usuario'])) {
    header('Location: bienvenidaCliente.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="styles.css">
    <style>
    /*No entiendo por qué no me funciona desde styles.css*/
    body {
      margin: 0;
      font-family: sans-serif;
    }

    .carrusel-contenedor {
      width: 100%;
      overflow: hidden;
      position: relative;
      background-color: #f0f0f0;
      padding: 20px 0;
    }

    .carrusel-track {
      display: flex;
      width: max-content;
      gap: 20px;
      animation: scroll-left 30s linear infinite;
    }

    .carrusel-track:hover {
      animation-play-state: paused;
    }

    .carrusel-track img {
      width: 300px;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      transition: transform 0.3s ease;
    }

    .carrusel-track img:hover {
      transform: scale(1.05);
    }

    @keyframes scroll-left {
      0% {
        transform: translateX(0);
      }
      100% {
        transform: translateX(-50%);
      }
    }
  </style>
    <title>VisiTahal</title>
</head>
<body>
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
        <a href="alojamiento.php"><img src="img/bungalo1.jpg" alt="bungalo"></a>
        <a href="alojamiento.php"><img src="img/bungalo4.jpg" alt="bungalo"></a>
        <a href="alojamiento.php"><img src="img/bungalo2.jpg" alt="bungalo"></a>
        <a href="alojamiento.php"><img src="img/bungalo6.jpg" alt="bungalo"></a>
        <a href="alojamiento.php"><img src="img/bungalo3.jpg" alt="bungalo"></a>
        <a href="alojamiento.php"><img src="img/bungalo5.jpg" alt="bungalo"></a>
        <a href="alojamiento.php"><img src="img/bungalo1.jpg" alt="bungalo"></a>
        <a href="alojamiento.php"><img src="img/bungalo4.jpg" alt="bungalo"></a>
        <a href="alojamiento.php"><img src="img/bungalo2.jpg" alt="bungalo"></a>
        <a href="alojamiento.php"><img src="img/bungalo6.jpg" alt="bungalo"></a>
        <a href="alojamiento.php"><img src="img/bungalo3.jpg" alt="bungalo"></a>
        <a href="alojamiento.php"><img src="img/bungalo5.jpg" alt="bungalo"></a>

      
    </div>
</div>


    <br><br>
    <h2>SERVICIOS</h2>
    <?php 
    $consultaServicios = $conexion->query("SELECT * FROM SERVICIO");

    while ($servicio = $consultaServicios->fetch(PDO::FETCH_ASSOC)) {
        $nombreArchivo = strtolower(str_replace(' ', '_', $servicio['nombre'])) . ".html"; 
        echo "<a href='$nombreArchivo'>" . htmlspecialchars($servicio['descripcion']) . "</a><br>";
    }

    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
    ?>

</body>
</html>
