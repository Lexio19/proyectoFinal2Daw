<?php
// Mostrar los servicios disponibles
session_start();
require_once 'conexion/Conexion.php';
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva de Bungalow</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("input[name='fechaInicio'], input[name='fechaFin']").on("change", function () {
                let fechaInicio = $("input[name='fechaInicio']").val();
                let fechaFin = $("input[name='fechaFin']").val();

                if (fechaInicio && fechaFin) {
                    $.ajax({
                        url: "verificarDisponibilidad.php",
                        type: "POST",
                        data: { fechaInicio: fechaInicio, fechaFin: fechaFin },
                        success: function (response) {
                            $("select[name='bungalow']").html(response);
                        },
                        error: function () {
                            alert("Hubo un error al obtener la disponibilidad.");
                        }
                    });
                }
            });
        });
    </script>
</head>
<body>
<?php if ($mensajeExito){?>
    <p style="color: green;"><?php echo htmlspecialchars($mensajeExito); ?></p>
<?php };
if ($mensajeError){ ?>
    <p style="color: red;"><?php echo htmlspecialchars($mensajeError); ?></p>
<?php }; ?>
    <form action="controladores/controladorReserva.php" method="POST">
        <br><br>
        <label for="fechaInicio">Fecha de entrada:</label>
        <input type="date" name="fechaInicio" required>
        <br><br>
        <label for="fechaFin">Fecha de salida:</label>
        <input type="date" name="fechaFin" required>

        <br><br>
        <label for="bungalow">Selecciona un bungalow:</label>
        <select name="bungalow" required>
            <option value="">Selecciona una fecha para ver disponibilidad</option>
        </select>

        <br><br>
        <button type="submit" name="reservar">Reservar</button>
    </form>
    <br><br>
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <button type="submit" name="cerrarSesion">Cerrar sesión</button>
            <br><br>
            <button type="submit" name="inicio">Inicio</button>
        </form>
    </div>
</body>
</html>