<?php 

try{
require_once 'Conexion.php';
require_once 'funcionesValidacion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "registrarse")) {

    $db= new Conexion;
    $conexion = $db->conectar();

    $dni = validarDNI(filter_input(INPUT_POST, "dni"));
    $email = validarEmail(filter_input(INPUT_POST, "email"));
    $usuario = validarUsuario(filter_input(INPUT_POST, "usuario"));
    $apellidos = validarApellidos(filter_input(INPUT_POST, "apellidos"));
    $password = validarPassword(filter_input(INPUT_POST, "password"));
    $codigoPostal = validarCodigoPostal(filter_input(INPUT_POST, "codigoPostal"));

    $errores = [];


    if(!validarDNI($dni)){
        $errores[] = "El DNI no es válido" . "<br>";
    }

    if (!validarEmail($email)) {
        $errores[] = "Email no válido" . "<br>";
    }

    if (!validarUsuario($usuario)) {
        $errores[] = "Usuario no válido" . "<br>";
    }

    if (!validarApellidos($apellidos)) {
        $errores[] = "Apellidos no válidos" . "<br>";
    }

    if (!validarPassword($password)) {
        $errores[] = "Contraseña no válida" . "<br>";
    }

    if (!validarCodigoPostal($codigoPostal)) {
        $errores[] = "Código postal no válido" . "<br>";
    }

    if (empty($errores)) {
        $passwordCifrada = password_hash($password, PASSWORD_DEFAULT);
        $idRol=2;
        $consulta = $conexion->prepare("INSERT INTO USUARIO (DNI, correoElectronico, contrasenna, nombre, apellidos, CP, idRol) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $consulta->bindParam(1, $dni, PDO::PARAM_STR);
        $consulta->bindParam(2, $email, PDO::PARAM_STR);
        $consulta->bindParam(3, $passwordCifrada, PDO::PARAM_STR);
        $consulta->bindParam(4, $usuario, PDO::PARAM_STR);
        $consulta->bindParam(5, $apellidos, PDO::PARAM_STR);
        $consulta->bindParam(6, $codigoPostal, PDO::PARAM_STR);
        $consulta->bindParam(7, $idRol, PDO::PARAM_INT);
        $consulta->execute();

        header('Location: index.php');
    } else {
        foreach ($errores as $error) {
            echo $error;
        }
    }


}}catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conexion = null; // Cerrar la conexión a la base de datos
}



?>