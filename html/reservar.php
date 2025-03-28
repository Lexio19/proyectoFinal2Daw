<?php
        // Mostrar los bungalows disponibles
        session_start();
        require 'Conexion.php';
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

        ?>

<form action="controladorReserva.php" method="POST">
    <label for="bungalow">Selecciona un bungalow:</label>
    <select name="bungalow" required>
        <?php
        // Obtener los bungalows disponibles desde la base de datos
        $consultaBungalows = $conexion->query("SELECT * FROM ALOJAMIENTO");
        while ($bungalow = $consultaBungalows->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $bungalow['idAlojamiento'] . "'>" . htmlspecialchars($bungalow['tipo']) . "</option>";
        }
        ?>
    </select>
    
       
    </select>
        <br><br>
    <label for="fecha_inicio">Fecha de entrada:</label>
    <input type="date" name="fecha_inicio" required>
        <br><br>
    <label for="fecha_fin">Fecha de salida:</label>
    <input type="date" name="fecha_fin" required>
<br><br>
    <button type="submit" name="reservar">Reservar</button>
</form>

<div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

    <button type="submit" name="cerrarSesion">Cerrar sesión</button>

    <br><br>
    <button type="submit" name="inicio">Inicio</button>
    
    </form>
