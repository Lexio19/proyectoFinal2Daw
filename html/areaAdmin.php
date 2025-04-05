<?php
session_start();   

if(filter_has_var(INPUT_POST, "cerrarSesion")){
    session_unset(); // Destruir todas las variables de sesión
    session_destroy();
    header('Location: index.php');
    exit; // Detener la ejecución después de redirigir
}


echo "BIENVENIDO A LA ZONA DE ADMINISTRADOR DE VisiTahal<br>";





?>
<br><br>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

<button type="submit" name="cerrarSesion">Cerrar sesión</button>

</form>
</div>