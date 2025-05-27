<?php
// Inicia el almacenamiento en buffer de salida (evita problemas con headers)
ob_start();
//Habilitamos la sesión
session_start();
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../funcionesValidacion/funcionesValidacion.php';
try {
$db = new Conexion;
$conexion = $db->conectar();
} catch (PDOException $ex) {
    $error = $ex->getMessage();
}

// Comprueba que el formulario se haya enviado por POST y que se haya pulsado el botón de 'autenticarse'
if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_has_var(INPUT_POST, "autenticarse")) {
    try {
        // Verifica que se han recibido correctamente los campos email y password
        if (((filter_input(INPUT_POST, "email") && (filter_input(INPUT_POST, "password"))) !== null)) {
            // Validación básica de los campos del formulario
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, "password");

            $errores = []; // Inicializamos el array de errores
            // Validamos el email y la contraseña
            if (empty($email) || empty($password) || !validarEmail($email) || !validarPassword($password)) {
                $errores[] = "Usuario o contraseñas incorrectos" . "<br>";
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
                // Verifica que la contraseña introducida coincida con el hash guardado
                if (password_verify($password, $fila['contrasenna'])) {
                    //Con este INNER JOIN nos ahorramos una consulta y comprobamos el rol del usuario
                    $consultaRolYTipoUsuario = $conexion->prepare("SELECT u.idRol, r.tipo FROM USUARIO u INNER JOIN "
                        . "ROL r ON u.idRol= r.idRol WHERE u.correoElectronico= ?");
                    $consultaRolYTipoUsuario->bindParam(1, $email, PDO::PARAM_STR);
                    $consultaRolYTipoUsuario->execute();
                    $fila = $consultaRolYTipoUsuario->fetch(PDO::FETCH_ASSOC);
        
                    if ($fila) {
                        // Consulta para obtener datos del usuario
                        $consultaDatosUsuario = $conexion->prepare("SELECT * FROM USUARIO WHERE correoElectronico = ?");
                        $consultaDatosUsuario->execute([$email]);
                        $datosUsuario = $consultaDatosUsuario->fetch(PDO::FETCH_ASSOC);
                        // Convierte el tipo de rol a minúsculas y sin espacios
                        $tipo = strtolower(trim($fila['tipo']));

                        // Redirigir según el tipo de rol usando un switch
                        switch ($tipo) {
                            case 'superadministrador':
                            case 'administrador':
                                $_SESSION['rol'] = $tipo;
                                $_SESSION['email'] = $email;
                                $_SESSION['DNI']= $datosUsuario['DNI'];
                                $_SESSION['usuario'] = $datosUsuario['nombre'];
                                $_SESSION['idUsuario'] = $datosUsuario['idUsuario'];
                                $dni= $datosUsuario['DNI'];
                                header('Location: ../principal/areaAdmin.php');
                                exit();
                                break;
                            case 'cliente':
                                $_SESSION['rol'] = $tipo;
                                $_SESSION['email'] = $email;
                                $_SESSION['DNI']= $datosUsuario['DNI'];
                                $_SESSION['usuario'] = $datosUsuario['nombre'];
                                $_SESSION['idUsuario'] = $datosUsuario['idUsuario'];
                                $nombreUsuario= $datosUsuario['nombre'];
                                header('Location: ../principal/bienvenidaCliente.php');
                                exit();
                                break;
                
                            default:
                                // Destruir la sesión si el rol no es válido
                                $errores[] = "Rol no encontrado.";
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
        $errores[]= "ERROR: $ex";
    }

    if (!empty($errores)) {
    // Guardamos los errores en sesión para recuperarlos luego en index.php
    $_SESSION['flash_error'] = $errores;
    header('Location: ../index.php');
    exit();
}
}



ob_end_flush();//Vaciar el buffer de salida