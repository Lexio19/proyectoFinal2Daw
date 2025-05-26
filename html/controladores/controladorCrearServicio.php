<?php
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';
session_start();
// Verificar si el usuario ha iniciado sesión y tiene el rol de administrador
if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "crearServicio")) {
    $nombre = filter_input(INPUT_POST, "nombre");
    $descripcion = filter_input(INPUT_POST, "descripcion");
    $aforo = filter_input(INPUT_POST, "aforo", FILTER_VALIDATE_INT);
    $diaServicio = filter_input(INPUT_POST, "diaServicio");
    
    $errores = [];
    if (!validarDiaSemana($diaServicio)) {
        $errores[] = "❌ Día de servicio no válido.";
    }


    if (empty($nombre)||empty($descripcion)||empty($aforo)||empty($diaServicio)) {
        $errores[] = "❌ Todos los campos son obligatorios.";
       
    }

    // Verificar imagen
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] != UPLOAD_ERR_OK) {
        $errores[] = "❌ Error al subir la imagen.";
    } else {
        // Procesar imagen
        $imagenTmp = $_FILES['imagen']['tmp_name'];
        // Obtener el nombre y la extensión de la imagen
        $imagenNombre = basename($_FILES['imagen']['name']);
        // Comprobar si la imagen tiene un nombre válido
        $ext = strtolower(pathinfo($imagenNombre, PATHINFO_EXTENSION));
        $nuevaRuta = '../img/servicios/' . uniqid() . '.' . $ext;

        // Validar extensión que puede tener la imagen
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($ext, $extensionesPermitidas)) {
            $errores[] = "❌ Formato de imagen no permitido.";
        }
    }

    try {
        $db = new Conexion();
        $conexion = $db->conectar();

        // Comprobar duplicado
        $consultaServicio = $conexion->prepare("SELECT * FROM SERVICIO WHERE nombre = :nombre");
        $consultaServicio->bindParam(':nombre', $nombre);
        $consultaServicio->execute();

        if ($consultaServicio->rowCount() > 0) {
            $errores[] = "❌ El servicio ya existe.";
        }
        if (empty($errores)) {
            if (!move_uploaded_file($imagenTmp, $nuevaRuta)) {
                throw new Exception("Error al guardar la imagen.");
            }
            $insertarServicio = $conexion->prepare("INSERT INTO SERVICIO (nombre, descripcion, aforo, diasServicio, imagenRuta) VALUES (?,?,?,?,?)");
            $insertarServicio->bindParam(1, $nombre);
            $insertarServicio->bindParam(2, $descripcion);
            $insertarServicio->bindParam(3, $aforo);
            $insertarServicio->bindParam(4, $diaServicio);
            $insertarServicio->bindParam(5, $nuevaRuta);
            $insertarServicio->execute();

            setFlash("success", "✅ Servicio creado con éxito.");
        } else {
            setFlash("error", implode("<br>", $errores));
        }

        // Redirigir a la vista de nuevo
        header("Location: ../principal/crearServicio.php");
        exit;

    } catch (PDOException $ex) {
        setFlash("error", "❌ Error de conexión: " . $ex->getMessage());
        header("Location: ../principal/crearServicio.php");
        exit;
    }
}
