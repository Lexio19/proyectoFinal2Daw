<?php
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';
session_start();
// Verificar si el usuario ha iniciado sesión y tiene el rol de administrador
if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "crearUsuario")) {
    $dni = filter_input(INPUT_POST, "dni");
    $correoElectronico = filter_input(INPUT_POST, "correoElectronico");
    $password = filter_input(INPUT_POST, "password");
    $nombre = filter_input(INPUT_POST, "nombre");
    $apellidos = filter_input(INPUT_POST, "apellidos");
    $codigoPostal = filter_input(INPUT_POST, "codigoPostal");
    
    $errores = [];
    // Validar los campos
    if (empty($dni)||empty($correoElectronico)||empty($password)||empty($nombre)||empty($apellidos)||empty($codigoPostal)) {
        $errores[] = "❌ Todos los campos son obligatorios.";
    }
    
    try {
        $db = new Conexion();
        $conexion = $db->conectar();

        // Comprobar duplicado
        $consultaUsuario = $conexion->prepare("SELECT * FROM USUARIO WHERE correoElectronico = :correoElectronico OR dni = :dni");
        $consultaUsuario->bindParam(':correoElectronico', $correoElectronico);
        $consultaUsuario->bindParam(':dni', $dni);
        $consultaUsuario->execute();

        if ($consultaUsuario->rowCount() > 0) {
            $errores[] = "❌ El usuario ya existe.";
        }
        // Si el usuario no existe, insertamos el nuevo usuario
        if (empty($errores)) {
            $passwordCifrada = password_hash($password, PASSWORD_DEFAULT);
            $insertarUsuarioCliente = $conexion->prepare("INSERT INTO USUARIO (DNI, correoElectronico, contrasenna, nombre, apellidos, CP, idRol) VALUES (?,?, ?, ?, ?, ?, ?)");
            $idRol = 2; // Asignar el rol de usuario cliente(2)
            $insertarUsuarioCliente->bindParam(1, $dni);
            $insertarUsuarioCliente->bindParam(2, $correoElectronico);
            $insertarUsuarioCliente->bindParam(3, $passwordCifrada);
            $insertarUsuarioCliente->bindParam(4, $nombre);
            $insertarUsuarioCliente->bindParam(5, $apellidos);
            $insertarUsuarioCliente->bindParam(6, $codigoPostal);
            $insertarUsuarioCliente->bindParam(7, $idRol);
            $insertarUsuarioCliente->execute();

            setFlash("success", "✅ Usuario creado con éxito.");
        } else {
            setFlash("error", implode("<br>", $errores));
        }

        // Redirigir a la vista de nuevo
        header("Location: ../principal/crearNuevoUsuario.php");
        exit;

    } catch (PDOException $ex) {
        setFlash("error", "❌ Error de conexión: " . $ex->getMessage());
        header("Location: ../principal/crearNuevoUsuario.php");
        exit;
    }
}
