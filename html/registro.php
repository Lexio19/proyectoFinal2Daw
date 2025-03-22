<?php

session_start();
require_once 'controladorRegistro.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h1>Bienvenido a la web de registro de VisiTahal</h1>

    <div class="formulario">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label>Introduzca su DNI</label><br>
        <input type="text" name="dni" value="<?php if (filter_has_var(INPUT_POST, "dni")) echo filter_input(INPUT_POST, "dni"); ?>"><br><br>
            <label>Introduzca su email</label><br>
            <input type="text" name="email" value="<?php if (filter_has_var(INPUT_POST, "email")) echo filter_input(INPUT_POST, "email"); ?>"><br><br>
            <label>Introduzca su nombre de usuario</label><br>
            <input type="text" name="usuario" value="<?php if (filter_has_var(INPUT_POST, "usuario")) echo filter_input(INPUT_POST, "usuario"); ?>"><br><br>

            <label>Introduzca sus apellidos</label><br>
            <input type="text" name="apellidos" value="<?php if (filter_has_var(INPUT_POST, "apellidos")) echo filter_input(INPUT_POST, "apellidos"); ?>"><br><br>
            
            <label>Introduzca la contraseña</label><br>
            <input type="text" name="password" value="<?php if (filter_has_var(INPUT_POST, "password")) echo filter_input(INPUT_POST, "password"); ?>"><br><br>

          
            <label>Introduzca su código postal</label><br>
            <input type="text" name="codigoPostal" value="<?php if (filter_has_var(INPUT_POST, "codigoPostal")) echo filter_input(INPUT_POST, "codigoPostal"); ?>"><br><br>
            <br><br>

            <button class="boton" type="submit" name="registrarse">Registrarse</button>
        </form>
    </div>

    <div>   
        <a href="index.php">Volver a la página de inicio</a>
    </div>
</body>
</html>