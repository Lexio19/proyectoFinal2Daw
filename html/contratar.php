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
    <title>Contratar un servicio</title>
</head>
<body>
<?php if ($mensajeExito){?>
    <p style="color: green;"><?php echo htmlspecialchars($mensajeExito); ?></p>
<?php };
if ($mensajeError){ ?>
    <p style="color: red;"><?php echo htmlspecialchars($mensajeError); ?></p>
<?php }; ?>

<form action="controladores/controladorContrata.php" method="POST">
    <label for="servicio">Selecciona un servicio:</label>
    <style>
.carrusel {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    gap: 1rem;
    padding: 1rem;
}
.servicio-card {
    min-width: 250px;
    border: 2px solid #ccc;
    border-radius: 10px;
    padding: 1rem;
    text-align: center;
    scroll-snap-align: start;
    cursor: pointer;
    transition: transform 0.2s, border-color 0.2s;
}
.servicio-card img {
    max-width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
}
.servicio-card.selected {
    border-color: green;
    transform: scale(1.05);
}
</style>

<div class="carrusel" id="carruselServicios">
    <?php
    $consultaServicios = $conexion->query("SELECT * FROM SERVICIO");
    while ($servicio = $consultaServicios->fetch(PDO::FETCH_ASSOC)) {
        $diasServicio = $servicio['diasServicio'];
        $imagenRuta = htmlspecialchars($servicio['imagenRuta']);
        $descripcion = htmlspecialchars($servicio['descripcion']);
        $idServicio = htmlspecialchars($servicio['idServicio']);
        echo "
        <div class='servicio-card' data-id='$idServicio' data-dias='$diasServicio'>
            <img src='$imagenRuta' alt='Imagen del servicio'>
            <h3>$descripcion</h3>
            <p>Días: $diasServicio</p>
            
        </div>";
    }
    ?>
</div>

<input type="hidden" name="servicio" id="inputServicio" required>


    <br><br>
    <label for="fechaContrata">Fecha del servicio:</label>
    <input type="date" name="fechaContrata" id="fechaContrata" required>
    <br><br>
    <p id="aforoDisponible" style="font-weight: bold;"></p>
    <button type="submit" name="reservar">Reservar</button>
</form>

<div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <button type="submit" name="cerrarSesion">Cerrar sesión</button>
    </form>
</div>

<script>
const tarjetas = document.querySelectorAll(".servicio-card");
const inputServicio = document.getElementById("inputServicio");
const inputFecha = document.getElementById("fechaContrata");

let diasPermitidos = [];

tarjetas.forEach(card => {
    card.addEventListener("click", () => {
        // Quitar selección anterior
        tarjetas.forEach(c => c.classList.remove("selected"));
        // Añadir clase seleccionada
        card.classList.add("selected");

        // Establecer el valor oculto del input
        const idServicio = card.getAttribute("data-id");
        inputServicio.value = idServicio;

        // Actualizar días disponibles
        const dias = card.getAttribute("data-dias");
        diasPermitidos = dias.split(",").map(d => d.trim().toLowerCase());

        inputFecha.disabled = false;
        inputFecha.value = "";

        // Calcular próxima fecha válida
        let hoy = new Date();
        let proxima = new Date(hoy);
        while (!diasPermitidos.includes(diaSemana(proxima))) {
            proxima.setDate(proxima.getDate() + 1);
        }
        inputFecha.setAttribute("min", proxima.toISOString().split("T")[0]);
if (inputServicio.value && inputFecha.value) {
    actualizarAforo(inputServicio.value, inputFecha.value);
}


    });
});

inputFecha.addEventListener("change", function () {
    const fecha = new Date(this.value);
    const dia = diaSemana(fecha);
    if (!diasPermitidos.includes(dia)) {
        alert("Solo puedes seleccionar los siguientes días: " + diasPermitidos.join(", "));
        this.value = "";
    }
});

function diaSemana(fecha) {
    const dias = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
    return dias[fecha.getDay()].toLowerCase();
}
</script>

<script>
function actualizarAforo(idServicio, fecha) {
    if (!idServicio || !fecha) {
        document.getElementById("aforoDisponible").innerText = "";
        return;
    }

    fetch(`aforoDisponibleServicios.php?idServicio=${idServicio}&fecha=${fecha}`)
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                document.getElementById("aforoDisponible").innerText = "Error al obtener aforo.";
            } else {
                document.getElementById("aforoDisponible").innerText = 
                    `Plazas disponibles: ${data.disponibles}`;
            }
        })
        .catch(() => {
            document.getElementById("aforoDisponible").innerText = "Error al consultar aforo.";
        });
}

// Actualizar aforo cuando cambies de servicio o fecha
inputFecha.addEventListener("change", () => {
    const id = inputServicio.value;
    const fecha = inputFecha.value;
    if (id && fecha) {
        actualizarAforo(id, fecha);
    }
});
</script>


<div>   
    <a href="index.php">Volver a la página de inicio</a>
</div>
 
</body>
</html>
