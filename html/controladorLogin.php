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
            $email = validarEmail(filter_input(INPUT_POST, "email"));
            $password = validarPassword(filter_input(INPUT_POST, "password"));

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
            $passwordCifrada = password_hash($password, PASSWORD_DEFAULT);

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
                    $consultaRolYTipoUusario = $conexion->prepare("SELECT u.id_rol, r.tipo FROM usuarios u INNER JOIN "
                        . "roles r ON u.id_rol= r.id_rol WHERE u.login= ?");
                    $consultaRolYTipoUusario->bindParam(1, $login, PDO::PARAM_STR);
                    $consultaRolYTipoUusario->execute();
                    $fila = $consultaRolYTipoUusario->fetch(PDO::FETCH_ASSOC);

                    if ($fila) {
                        $tipo = $fila['tipo'];

                        // Redirigir según el tipo de rol usando un switch
                        switch ($tipo) {
                            case 'administrador':
                                $_SESSION['rol'] = $tipo;
                                header('Location: areaAdmin.php?usuario=' . $login);
                                break;
                            case 'usuario':
                                $_SESSION['rol'] = $tipo;
                                header('Location: paginaUsuario.php?usuario=' . $login);
                                break;
                            case 'invitado':
                                $_SESSION['rol'] = $tipo;
                                header('Location: verEspectaculo.php?usuario=' . $login);
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
}
?>

