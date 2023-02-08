<?php
require('configuracion.php');

class Conexion{
  protected $conexion_db;
  public function __construct(){
    $this->conexion_db = new mysqli(DB_SERVER, DB_USUARIO, DB_CONTRASENA, DB_NOMBRE);
    if ($this->conexion_db->connect_errno) {
      echo "Error al conectar MySql" . $this->conexion_db->connect_error;
      return;
      }
      $this->conexion_db->set_charset(DB_CHARSET);
  }
}


 ?>
