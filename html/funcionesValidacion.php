<?php

function sanearTexto($campo) {
    $campo = trim($campo);
    $campo = strip_tags($campo);
    $campo = htmlspecialchars($campo, ENT_QUOTES);
    $campo = str_replace('+', '', $campo);
    return $campo;
}

function validarEmail($email) {
    $emailSaneado = sanearTexto($email); 
    
    if (!filter_var($emailSaneado, FILTER_VALIDATE_EMAIL)) {
        $emailSaneado = false;
    }
    
    return $emailSaneado;
}
//Sirve para DNI y NIE
function validarDNI($dni) {
    $dniSaneado = sanearTexto($dni);
    
    if (!preg_match('/^([0-9]{8}[A-Z]|[XYZ][0-9]{7}[A-Z])$/', $dniSaneado)) {
        $dniSaneado = false;
    }
    
    return $dniSaneado;
}




//La contraseña deberá tener al menos 5 caracteres, una mayúscula y un número
function validarPassword($password){
    $passwordSaneado = sanearTexto($password);
    if (!preg_match("/^(?=.*[A-Z])(?=.*\d).{5,}$/", $passwordSaneado)) {
        $passwordSaneado = false;
    }
    
    return $passwordSaneado;
}

function validarUsuario($usuario){
    // Sanear texto para prevenir posibles inyecciones o caracteres no deseados
    $usuarioSaneado = sanearTexto($usuario);
    
    // Expresión regular actualizada para aceptar letras, tildes, ñ y espacios
    if (!preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+(?:\s[A-Za-zÁÉÍÓÚáéíóúÑñ]+)*$/', $usuarioSaneado)) {
        // Si no pasa la validación, se asigna false
        $usuarioSaneado = false;
    }
    
    return $usuarioSaneado;
}


//1 ó 2 apellidos, separados, no sensitivo a mayúsculas ni minúsculas
function validarApellidos($apellidos){
    $apellidosSaneado = sanearTexto($apellidos);
    if (!preg_match("/^[a-záéíóúñ]+( [a-záéíóúñ]+)?$/iu", $apellidosSaneado)) {
        $apellidosSaneado = false;
    }
    
    return $apellidosSaneado;
}

function validarCodigoPostal($codigoPostal){
    $codigoPostalSaneado = sanearTexto($codigoPostal);
    if (!preg_match("/^\d{5}$/", $codigoPostalSaneado)) {
        $codigoPostalSaneado = false;
    }
    
    return $codigoPostalSaneado;
}

//Función para validar el día

function validarDiaSemana($dia) {
    // Sanear el texto
    $diaSaneado = trim(mb_strtolower(sanearTexto($dia), 'UTF-8'));

    // Lista de días válidos estandarizados
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

    // Estandarizar el día o devolver false si no es válido
    $diaSaneado = $diasEstandarizados[$diaSaneado] ?? false;

    return $diaSaneado;
}



//Funciones de mensajes Flash. Evito mostrar los mensajes en 
//la página del controlador.


function setFlash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}
