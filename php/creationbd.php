<?php

// Creación de la base de datos

requiere_once 'creationdb_queries.php';
requiere_once 'connection.php';

    if(mysqli_query($connect, $sqlALL))
    {
        print "Base de datos Proyecto1 creada";            
    }
    else
    {
        print "Error creando la base de datos: " . mysqli_error($connect);
    }
?>