<?php
// Mostrar los servicios disponibles
session_start();
require_once 'Conexion.php';
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
    <title>Contratar un servicio</title>
</head>
<body>
<?php if ($mensajeExito){?>
    <p style="color: green;"><?php echo htmlspecialchars($mensajeExito); ?></p>
<?php };
if ($mensajeError){ ?>
    <p style="color: red;"><?php echo htmlspecialchars($mensajeError); ?></p>
<?php }; ?>

<form action="controladorContrata.php" method="POST">
    <label for="servicio">Selecciona un servicio:</label>
    <select name="servicio" id="servicio" required onchange="actualizarDiasServicio()">
        <option value="" disabled selected>Selecciona un servicio</option>
        <?php
        // Obtener los servicios disponibles desde la base de datos
        $consultaServicios = $conexion->query("SELECT * FROM SERVICIO");
        while ($servicio = $consultaServicios->fetch(PDO::FETCH_ASSOC)) {
            // Recuperamos los días disponibles como una cadena de texto
            $diasServicio = $servicio['diasServicio']; // Ejemplo: "Lunes, Miércoles, Viernes"
            $imagenRuta = $servicio['imagenRuta']; // Ruta de la imagen

            // Mostrar el servicio con su imagen
            echo "<option value='" . $servicio['idServicio'] . "' data-dias='" . htmlspecialchars($diasServicio) . "'>";
            echo htmlspecialchars($servicio['descripcion']) . " (" . htmlspecialchars($diasServicio) . ")</option>";
            // Mostrar la imagen en la lista desplegable o en alguna parte de la interfaz
            echo "<div><img src='" . htmlspecialchars($imagenRuta) . "' alt='Imagen del servicio' style='width: 100px; height: 100px;'></div>";
        }
        ?>
    </select>

    <br><br>
    <label for="fechaContrata">Fecha del servicio:</label>
    <input type="date" name="fechaContrata" id="fechaContrata" required>
    <br><br>

    <button type="submit" name="reservar">Reservar</button>
</form>

<div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <button type="submit" name="cerrarSesion">Cerrar sesión</button>
    </form>
</div>

<script>
function actualizarDiasDisponibles() {
    const selectServicio = document.getElementById("servicio");
    const inputFecha = document.getElementById("fechaContrata");
    const diasDisponibles = selectServicio.options[selectServicio.selectedIndex].getAttribute("data-dias");

    inputFecha.value = ""; // Resetear el campo de fecha
    
    if (!diasDisponibles) {
        inputFecha.disabled = true;
        return;
    }

    inputFecha.disabled = false;

    const diasPermitidos = diasDisponibles.split(",").map(d => d.trim().toLowerCase());

    // Buscar la primera fecha válida disponible
    let hoy = new Date();
    let proximaFecha = new Date(hoy);
    
    while (!diasPermitidos.includes(diaSemana(proximaFecha))) {
        proximaFecha.setDate(proximaFecha.getDate() + 1);
    }

    inputFecha.setAttribute("min", proximaFecha.toISOString().split("T")[0]);

    // Bloquear fechas no permitidas
    inputFecha.addEventListener("change", function () {
        const fechaSeleccionada = new Date(this.value);
        const diaSeleccionado = diaSemana(fechaSeleccionada);

        if (!diasPermitidos.includes(diaSeleccionado)) {
            alert("Solo puedes seleccionar los siguientes días: " + diasPermitidos.join(", "));
            this.value = ""; // Borrar fecha si no es válida
        }
    });
}

function diaSemana(fecha) {
    const dias = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
    return dias[fecha.getDay()].toLowerCase();
}
</script>

<div>   
    <a href="index.php">Volver a la página de inicio</a>
</div>
 
</body>
</html>
