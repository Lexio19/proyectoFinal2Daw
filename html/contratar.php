<?php
// Mostrar los servicios disponibles
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
    <label for="servicio">Selecciona un servicio:</label>
    <select name="servicio" id="servicio" required onchange="actualizarDiasDisponibles()">
        <option value="" disabled selected>Selecciona un servicio</option>
        <?php
        // Obtener los servicios disponibles desde la base de datos
        $consultaServicios = $conexion->query("SELECT * FROM SERVICIO");
        while ($servicio = $consultaServicios->fetch(PDO::FETCH_ASSOC)) {
            // Recuperamos los días disponibles como una cadena de texto
            $diasDisponibles = $servicio['diasDisponibles']; // Ejemplo: "Lunes, Miércoles, Viernes"
            echo "<option value='" . $servicio['idServicio'] . "' data-dias='" . htmlspecialchars($diasDisponibles) . "'>"
                . htmlspecialchars($servicio['descripcion']) . 
                "</option>";
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
        <br><br>
        <button type="submit" name="inicio">Inicio</button>
    </form>
</div>

<script>
function actualizarDiasDisponibles() {
    let selectServicio = document.getElementById("servicio");
    let diasDisponibles = selectServicio.options[selectServicio.selectedIndex].getAttribute("data-dias");
    let inputFecha = document.getElementById("fechaContrata");

    if (!diasDisponibles) {
        inputFecha.value = ""; // Resetear campo si no hay días disponibles
        inputFecha.disabled = true;
        return;
    }

    inputFecha.disabled = false;

    // Convertimos la cadena de días disponibles en un array y la normalizamos a minúsculas
    let diasPermitidos = diasDisponibles.split(",").map(dia => dia.trim().toLowerCase());

    // Ajustar la fecha mínima al primer día disponible
    let hoy = new Date();
    let diaHoy = hoy.getDay(); // 0 = Domingo, 6 = Sábado

    let proximaFecha = new Date(hoy);
    // Buscar el primer día disponible
    while (!diasPermitidos.includes(diaSemana(proximaFecha))) {
        proximaFecha.setDate(proximaFecha.getDate() + 1);
    }

    let fechaMinima = proximaFecha.toISOString().split("T")[0];
    inputFecha.setAttribute("min", fechaMinima);

    // Escuchamos el evento de cambio de fecha
    inputFecha.addEventListener("input", function () {
        let fechaSeleccionada = new Date(this.value);
        let diaSeleccionado = diaSemana(fechaSeleccionada); // Nombre del día (e.g. "lunes", "martes")

        // Comprobamos si el día seleccionado es uno de los permitidos
        if (!diasPermitidos.includes(diaSeleccionado)) {
            alert("Solo puedes seleccionar los siguientes días: " + diasPermitidos.join(", "));
            this.value = ""; // Borrar fecha si no es válida
        }
    });
}

// Función para obtener el nombre del día en minúsculas
function diaSemana(fecha) {
    const dias = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
    return dias[fecha.getDay()].toLowerCase();
}
</script>

<div>   
    <a href="index.php">Volver a la página de inicio</a>
</div>
