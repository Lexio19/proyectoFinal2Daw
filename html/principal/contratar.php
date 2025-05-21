<?php
// Página que muestra los servicios disponibles
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';
try{
$db = new Conexion();
$conexion = $db->conectar();
}catch (PDOException $ex) {
    $error = $ex->getMessage();
}

//Si el usuario no ha iniciado sesión, lo redirigimos al inicio
if (!isset($_SESSION['usuario'])) {
    header('Location: /../index.php');
    exit; // Detener la ejecución después de redirigir
}
//Botones de cerrar sesión e ir al inicio
if(filter_has_var(INPUT_POST, "cerrarSesion")){
    session_unset(); // Destruir todas las variables de sesión
    session_destroy();
    header('Location: /../index.php');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/../styles/styles.css">
    <title>Contratar un servicio</title>
</head>
<body>
    <div class="contenedor-global">
    <div class="container mt-4">
<?php if ($mensajeExito){?>
    <p style="color: green;"><?php echo htmlspecialchars($mensajeExito); ?></p>
<?php };
if ($mensajeError){ ?>
    <p style="color: red;"><?php echo htmlspecialchars($mensajeError); ?></p>
<?php }; ?>

<form action="/../controladores/controladorContrata.php" method="POST">
    <label for="servicio">Selecciona un servicio:</label>
  

<div class="carrusel" id="carruselServicios">
    <?php
    $consultaServicios = $conexion->query("SELECT * FROM SERVICIO");
    while ($servicio = $consultaServicios->fetch(PDO::FETCH_ASSOC)) {
        $diasServicio = $servicio['diasServicio'];
        $imagenRuta = '/' . ltrim($servicio['imagenRuta'], '/');
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
    <button type="submit" name="contratar">Contratar servicio</button>
</form>

<div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <button type="submit" name="cerrarSesion">Cerrar sesión</button>
            <br><br>
            <button type="submit" name="inicio">Inicio</button>
        </form>
    </div>

<script>
    // Seleccionamos todas las tarjetas que representan servicios
    const tarjetas = document.querySelectorAll(".servicio-card");
    // Input oculto donde se guarda el id del servicio seleccionado para enviar en el formulario
    const inputServicio = document.getElementById("inputServicio");
    // Input de tipo fecha donde el usuario selecciona la fecha del servicio
    const inputFecha = document.getElementById("fechaContrata");

    // Array donde almacenaremos los días permitidos para el servicio seleccionado (ej: ["lunes", "martes"])
    let diasPermitidos = [];

    // Para cada tarjeta de servicio añadimos un evento que detecta el clic
    tarjetas.forEach(card => {
        card.addEventListener("click", () => {
            // Primero quitamos la clase "selected" a todas para que solo una quede seleccionada
            tarjetas.forEach(c => c.classList.remove("selected"));
            // Añadimos la clase "selected" a la tarjeta clicada para destacarla visualmente
            card.classList.add("selected");

            // Obtenemos el ID del servicio de un atributo data-id y lo guardamos en el input oculto
            const idServicio = card.getAttribute("data-id");
            inputServicio.value = idServicio;

            // Obtenemos los días permitidos (string) y lo convertimos en array en minúsculas
            const dias = card.getAttribute("data-dias");
            diasPermitidos = dias.split(",").map(d => d.trim().toLowerCase());

            // Habilitamos el selector de fecha y limpiamos cualquier valor anterior
            inputFecha.disabled = false;
            inputFecha.value = "";

            // Calculamos la próxima fecha válida (desde hoy en adelante) según los días permitidos
            let hoy = new Date();
            let proxima = new Date(hoy);
            // Avanzamos la fecha hasta encontrar un día permitido
            while (!diasPermitidos.includes(diaSemana(proxima))) {
                proxima.setDate(proxima.getDate() + 1);
            }
            // Establecemos la fecha mínima seleccionable en el input de fecha
            inputFecha.setAttribute("min", proxima.toISOString().split("T")[0]);

            // Si ya hay servicio y fecha seleccionados, actualizamos el aforo mostrado
            if (inputServicio.value && inputFecha.value) {
                actualizarAforo(inputServicio.value, inputFecha.value);
            }
        });
    });

    // Validamos que la fecha seleccionada pertenezca a los días permitidos
    inputFecha.addEventListener("change", function () {
        const fecha = new Date(this.value);
        const dia = diaSemana(fecha);
        // Si el día no está en los permitidos, mostramos alerta y limpiamos la fecha
        if (!diasPermitidos.includes(dia)) {
            alert("Solo puedes seleccionar los siguientes días: " + diasPermitidos.join(", "));
            this.value = "";
        } else {
            // Si es válido, actualizamos el aforo para ese servicio y fecha
            actualizarAforo(inputServicio.value, this.value);
        }
    });

    // Función que devuelve el nombre del día de la semana en minúsculas para una fecha dada
    function diaSemana(fecha) {
        const dias = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
        return dias[fecha.getDay()].toLowerCase();
    }
</script>

<script>
    // Función para consultar y mostrar el aforo disponible para un servicio en una fecha
    function actualizarAforo(idServicio, fecha) {
        // Si falta id o fecha, limpiamos el texto y salimos
        if (!idServicio || !fecha) {
            document.getElementById("aforoDisponible").innerText = "";
            return;
        }

        // Realizamos una petición fetch al backend que devuelve el aforo en JSON
        fetch(`aforoDisponibleServicios.php?idServicio=${idServicio}&fecha=${fecha}`)
            .then(res => res.json()) // Convertimos la respuesta a JSON
            .then(data => {
                if (data.error) {
                    // Si hay error, mostramos mensaje correspondiente
                    document.getElementById("aforoDisponible").innerText = "Error al obtener aforo.";
                } else {
                    // Mostramos el número de plazas disponibles
                    document.getElementById("aforoDisponible").innerText = 
                        `Plazas disponibles: ${data.disponibles}`;
                }
            })
            .catch(() => {
                // En caso de fallo en la conexión o respuesta, mostramos error genérico
                document.getElementById("aforoDisponible").innerText = "Error al consultar aforo.";
            });
    }

    // Cada vez que se cambie la fecha, si hay servicio y fecha válidos, actualizamos el aforo
    inputFecha.addEventListener("change", () => {
        const id = inputServicio.value;
        const fecha = inputFecha.value;
        if (id && fecha) {
            actualizarAforo(id, fecha);
        }
    });
</script>


</div>
</body>
<footer class="bg-dark text-white text-center text-lg-start mt-5">
    <div class="container p-4">
        <div class="row">
            <!-- Información general -->
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Redes sociales</h5>
                <p>
                   <a href="https://www.instagram.com/ayuntamientotahal/" class="text-white">Instagram</a><br>
                   <a href="https://www.tiktok.com/search?q=ayuntamientotahal&t=1747319630493" class="text-white">TikTok</a><br>
                   <a href="https://www.facebook.com/ayuntamientotahal/" class="text-white">Facebook</a><br>

                </p>
            </div>

            
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Contacto</h5>
                <ul class="list-unstyled mb-0">
                    <li><i class="bi bi-envelope"></i> contacto@visitahal.es</li>
                    <li><i class="bi bi-telephone"></i> +34 123 456 789</li>
                    <li><i class="bi bi-geo-alt"></i> Tahal, Almería, España</li>
                </ul>
            </div>

            
            <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Ayuntamiento de Tahal</h5>
                   <a href="https://www.tahal.es/" class="text-white">Web del ayuntamiento</a><br>
                
            </div>
        </div>
    </div>
    <div class="text-center p-3 bg-secondary">
        © <?php echo date("Y"); ?> VisiTahal. Todos los derechos reservados.
    </div>
</footer>
</html>
