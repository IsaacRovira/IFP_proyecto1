<?php

requiere_once 'dbconfig.php';

// Utilizamos la función new mysqli(host, usuario, pass) para la conexión.

$connect = mysqli_connect($host, $user, $pass);

if($connect->connect_error)
{
 die("Imposible conectar: " . $connect->connect_error);
}

print ()"<p>¡Conexión realizada!</p>\n");
?>