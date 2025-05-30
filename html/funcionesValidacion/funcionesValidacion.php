<?php

/**
 * Sanea un texto eliminando etiquetas, espacios innecesarios y caracteres especiales peligrosos.
 * @param string $campo El texto a sanear.
 * @return string El texto saneado.
 */
function sanearTexto($campo) {
    $campo = trim($campo);
    $campo = strip_tags($campo);
    $campo = htmlspecialchars($campo, ENT_QUOTES);
    $campo = str_replace('+', '', $campo);
    return $campo;
}

/**
 * Valida una dirección de correo electrónico.
 * @param string $email La dirección de correo electrónico a validar.
 * @return string|false El email validado o false si no es válido.
 */
function validarEmail($email) {
    $emailSaneado = sanearTexto($email); 
    return filter_var($emailSaneado, FILTER_VALIDATE_EMAIL) ? $emailSaneado : false;
}

/**
 * Valida un DNI o NIE español.
 * @param string $dni El DNI o NIE a validar.
 * @return string|false El DNI/NIE validado o false si no es válido.
 */
function validarDNI($dni) {
    $dniSaneado = sanearTexto($dni);
    return preg_match('/^([0-9]{8}[A-Z]|[XYZ][0-9]{7}[A-Z])$/', $dniSaneado) ? $dniSaneado : false;
}

/**
 * Valida una contraseña. Debe tener al menos 5 caracteres, una letra mayúscula y un número.
 * @param string $password La contraseña a validar.
 * @return string|false La contraseña validada o false si no cumple con los requisitos.
 */
function validarPassword($password){
    $passwordSaneado = sanearTexto($password);
    return preg_match("/^(?=.*[A-Z])(?=.*\d).{5,}$/", $passwordSaneado) ? $passwordSaneado : false;
}

/**
 * Valida un nombre de usuario. Acepta letras, tildes, ñ y espacios.
 * @param string $usuario El nombre de usuario a validar.
 * @return string|false El nombre de usuario validado o false si no es válido.
 */
function validarUsuario($usuario){
    $usuarioSaneado = sanearTexto($usuario);
    return preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+(?:\s[A-Za-zÁÉÍÓÚáéíóúÑñ]+)*$/', $usuarioSaneado) ? $usuarioSaneado : false;
}

/**
 * Valida uno o dos apellidos. No distingue entre mayúsculas y minúsculas.
 * @param string $apellidos Los apellidos a validar.
 * @return string|false Los apellidos validados o false si no son válidos.
 */
function validarApellidos($apellidos){
    $apellidosSaneado = sanearTexto($apellidos);
    return preg_match("/^[a-záéíóúñ]+( [a-záéíóúñ]+)?$/iu", $apellidosSaneado) ? $apellidosSaneado : false;
}

/**
 * Valida un código postal español (5 dígitos).
 * @param string $codigoPostal El código postal a validar.
 * @return string|false El código postal validado o false si no es válido.
 */
function validarCodigoPostal($codigoPostal){
    $codigoPostalSaneado = sanearTexto($codigoPostal);
    return preg_match("/^\d{5}$/", $codigoPostalSaneado) ? $codigoPostalSaneado : false;
}

/**
 * Valida y estandariza el nombre de un día de la semana.
 * @param string $dia El día a validar.
 * @return string|false El día estandarizado o false si no es válido.
 */
function validarDiaSemana($dia) {
    $diaSaneado = trim(mb_strtolower(sanearTexto($dia), 'UTF-8'));

    $diasEstandarizados = [
        'lunes' => 'Lunes',
        'martes' => 'Martes',
        'miércoles' => 'Miércoles',
        'miercoles' => 'Miércoles',
        'jueves' => 'Jueves',
        'viernes' => 'Viernes',
        'sábado' => 'Sábado',
        'sabado' => 'Sábado',
        'domingo' => 'Domingo'
    ];

    return $diasEstandarizados[$diaSaneado] ?? false;
}

/**
 * Almacena un mensaje flash en la sesión.
 * @param string $key Clave identificadora del mensaje.
 * @param string $message El mensaje a guardar.
 * @return void
 */
function setFlash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

/**
 * Recupera y elimina un mensaje flash de la sesión.
 * @param string $key Clave identificadora del mensaje.
 * @return string|null El mensaje si existe, o null si no existe.
 */
function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}
