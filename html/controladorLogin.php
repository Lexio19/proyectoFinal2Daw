<?php

session_start();
require_once 'Conexion.php';
require_once 'funcionesValidacion.php';
$db = new Conexion;
$conexion = $db->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "autenticarse")) {
    try {
        // Se puede meter todo en un do-while para controlar mejor las veces que dejamos al usuario intentar la autenticación
        if ((filter_input(INPUT_POST, "email") && (filter_input(INPUT_POST, "password") !== null))) {
            // Validación básica de los campos del formulario
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, "password");

            $errores = []; // Inicializamos el array de errores

            if (!validarEmail($email)) {
                $errores[] = "Email no válido" . "<br>";
            }

            if (!validarPassword($password)) {
                $errores[] = "Contraseña no válida" . "<br>";
            }
        } else {
            $errores[] = "No se han recibido los datos correctamente";
        }

        if (empty($errores)) {
            // Conexión a la base de datos
            

            // Consulta preparada para obtener la clave del usuario
            $consultaPassword = $conexion->prepare("SELECT contrasenna FROM USUARIO WHERE correoElectronico = ?");
            $consultaPassword->bindParam(1, $email, PDO::PARAM_STR);
            $consultaPassword->execute();
            $fila = $consultaPassword->fetch(PDO::FETCH_ASSOC);

            // Si encontramos al usuario en la BBDD
            if ($fila) {
                // Si el usuario y la contraseña coinciden, comprobamos su rol con consultas preparadas
                if (password_verify($password, $fila['contrasenna'])) {
                    //Con este INNER JOIN nos ahorramos una consulta
                    $consultaRolYTipoUsuario = $conexion->prepare("SELECT u.idRol, r.tipo FROM USUARIO u INNER JOIN "
                        . "ROL r ON u.idRol= r.idRol WHERE u.correoElectronico= ?");
                    $consultaRolYTipoUsuario->bindParam(1, $email, PDO::PARAM_STR);
                    $consultaRolYTipoUsuario->execute();
                    $fila = $consultaRolYTipoUsuario->fetch(PDO::FETCH_ASSOC);

                    if ($fila) {
                        $tipo = $fila['tipo'];

                        // Redirigir según el tipo de rol usando un switch
                        switch ($tipo) {
                            case 'administrador':
                                $_SESSION['rol'] = $tipo;
                                header('Location: areaAdmin.php?usuario=' . $email);
                            
                                break;
                            case 'cliente':
                                $_SESSION['rol'] = $tipo;
                                header('Location: bienvenidoCliente.php?usuario=' . $email);
                                break;
                        }
                    } else {
                        $errores[] = "Rol no encontrado.";
                    }
                } else {
                    $errores[] = "Usuario o contraseña incorrectos";
                }
            } else {
                $errores[] = "Usuario o contraseña incorrectos";
            }

            // Siempre cerramos la conexión
            $conexion = $db->cerrarConexion();
        }

    } catch (Exception $ex) {
        echo "ERROR: $ex";
    }

    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
    
}
?>

