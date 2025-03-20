<?php

// Uso de la clase
// $db = new Conexion();
// $conexion = $db->conectar();
// $db->cerrarConexion();
class Conexion {
    private $servidor;
    private $usuario;
    private $contrasenna;
    private $bbdd;
    private $conexion;

    public function __construct(
        $servidor = 'localhost', 
        $usuario = 'root', 
        $contrasenna = 'rootpassword', 
        $bbdd = 'PROYECTO_VISITAHAL'
    ) {
        $this->servidor = $servidor;
        $this->usuario = $usuario;
        $this->contrasenna = $contrasenna;
        $this->bbdd = $bbdd;
    }

    public function conectar() {
        try{
            $conexionPDO = "mysql:host={$this->servidor}; dbname={$this->bbdd}; charset=utf8";
            $this->conexion= new PDO($conexionPDO, $this->usuario, $this->contrasenna);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $ex) {
            die("Se ha producido un error de conexión ". $ex->getMessage());
        }
      
    }

    public function cerrarConexion() {
        return $this->conexion = null;
        }
    }

