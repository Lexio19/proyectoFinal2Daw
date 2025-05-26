<?php
// Página que muestra los bungalós disponibles para reservar
// y permite al usuario seleccionar fechas y bungalós para realizar una reserva.
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';
try{
$db = new Conexion();
$conexion = $db->conectar();
}catch (PDOException $ex) {
    $error = $ex->getMessage();
}


// Verifica si el usuario ha iniciado sesión; si no, lo redirige al inicio
if (!isset($_SESSION['usuario'])) {
    header('Location: /../index.php');
    exit; // Detener la ejecución después de redirigir
}
//Botonos de cerrar sesión e ir al inicio
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
    <!-- Estilos de Bootstrap y CSS propio -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/../styles/styles.css">
    <title>Reserva de Bungalow</title>
     <!-- jQuery para AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Script para actualizar automáticamente los bungalós disponibles -->
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
    <div class="contenedor-global">
        <div class="container mt-4">
<?php if ($mensajeExito){?>
    <p style="color: green;"><?php echo htmlspecialchars($mensajeExito); ?></p>
<?php };
if ($mensajeError){ ?>
    <p style="color: red;"><?php echo htmlspecialchars($mensajeError); ?></p>
<?php }; ?>
<h1>RESERVA DE BUNGALÓS</h1>
<main class="galeria">
    <div class="foto">
      <img src="/../img/bungalo3.jpg" alt="Bungaló junto al lago">
      
    </div>
    <div class="foto">
      <img src="/../img/bungalo2.jpg" alt="Bungaló entre árboles">
      
    </div>
    <div class="foto">
      <img src="/../img/merendero6.jpg" alt="Bungaló con vista a la montaña">
      
    </div>
    <div class="foto">
      <img src="/../img/bungalo4.jpg" alt="Bungaló aislado para dos">
      
    </div>
    <div class="foto">
        <img src="/../img/bungalo5.jpg" alt="Bungaló aislado para dos">
        
      </div>
      <div class="foto">
        <img src="/../img/bungalo10.jpg" alt="Bungaló aislado para dos">
        
      </div>
      <div class="foto">
        <img src="/../img/castillo3.jpg" alt="Bungaló aislado para dos">
        
      </div>
      <div class="foto">
        <img src="/../img/bungalo9.jpg" alt="Bungaló aislado para dos">
        
      </div>
  </main>
    <form action="/../controladores/controladorReserva.php" method="POST">
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
            <button type="submit" name="inicio">Inicio</button>
            
            <br><br>
        <button type="submit" name="cerrarSesion">Cerrar sesión</button>
            
        </form>
    </div>
</body>
</div>
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