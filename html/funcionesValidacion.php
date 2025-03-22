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

function validarDNI($dni) {
    $dniSaneado = sanearTexto($dni);
    
    if (!preg_match('/^[0-9]{8}[A-Z]$/', $dniSaneado)) {
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
    $usuarioSaneado = sanearTexto($usuario);
    if (!preg_match('/^[A-Z][a-zA-Z]{1,19}$/', $usuarioSaneado)) {
        $usuarioSaneado = false;
    }
    
    return $usuarioSaneado;
}

function validarApellidos($apellidos){
    $apellidosSaneado = sanearTexto($apellidos);
    if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+ [A-Za-zÁÉÍÓÚáéíóúÑñ]+$/", $apellidosSaneado)) {
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

