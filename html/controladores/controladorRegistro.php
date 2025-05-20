<?php 
try{
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "registrarse")) {

    $db= new Conexion;
    $conexion = $db->conectar();
    //Sanemos los datos que recibimos del formulario
    $dni = validarDNI(filter_input(INPUT_POST, "dni"));
    $email = validarEmail(filter_input(INPUT_POST, "email"));
    $usuario = validarUsuario(filter_input(INPUT_POST, "usuario"));
    $apellidos = validarApellidos(filter_input(INPUT_POST, "apellidos"));
    $password = validarPassword(filter_input(INPUT_POST, "password"));
    $codigoPostal = validarCodigoPostal(filter_input(INPUT_POST, "codigoPostal"));
    //Este array contendrá los errores que se vayan produciendo
    $errores = [];

    //Validamos los datos
    if(!validarDNI($dni)){
        $errores[] = "El DNI no es válido";
    }

    if (!validarEmail($email)) {
        $errores[] = "Email no válido";
    }

    if (!validarUsuario($usuario)) {
        $errores[] = "Usuario no válido";
    }

    if (!validarApellidos($apellidos)) {
        $errores[] = "Apellidos no válidos";
    }

    if (!validarPassword($password)) {
        $errores[] = "Contraseña no válida";
    }

    if (!validarCodigoPostal($codigoPostal)) {
        $errores[] = "Código postal no válido";
    }
    //Si no hay errores, procedemos a insertar el usuario en la base de datos
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
        setFlash("success", "¡Registro confirmado!");
        header('Location: ../index.php');
        exit;
    } else {  
    setFlash("error", "Errores:\n - " . implode("\n - ", $errores));   
    }


}}catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conexion = null; // Cerrar la conexión a la base de datos
}



?>