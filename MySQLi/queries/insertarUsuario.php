<?php 
    require_once('db/ConexionMYSQL.php');

    // Database connection
    $conn = new ConexionMYSQL();
    $db = $conn->crearConexion();
    $db->set_charset('utf8');

    // Insert values into database using query
    $res = $db->query('INSERT INTO ejercicio10_usuarios(nombre, pass) VALUES ("paco", "paco")');
    $res = $db->query("INSERT INTO ejercicio10_usuarios(nombre, pass) VALUES ('pepe', 'pepe')");

    // Confirm message
    echo 'Se han insertado 2 usuarios';

    // Free memory
    $res->free();

    // Closing the database connection
    $conn->cerrarConexion();

?>