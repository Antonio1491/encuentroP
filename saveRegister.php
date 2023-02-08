<?php

require "./class/clases.php";

$usuario = new Usuarios;

if($_POST)
{
    // $mensaje = "Datos recibidos";
    $save = $usuario->saveUsuario($_POST);
    if ($save){
        header('Location: gracias.html');
    }
    else{
        header('Location: error.html');
    }
}
else{
    header('Location: error.html');
}




?>