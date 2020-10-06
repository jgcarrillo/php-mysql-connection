<?php 
    require_once('db/ConexionMYSQL.php');

    // Database connection
    $conn = new ConexionMYSQL();
    $db = $conn->crearConexion();
    $db->set_charset('utf8');

    // Insert values into database using prepared statement
    $stmt = $db->prepare('INSERT INTO ejercicio10_usuarios(nombre, pass) VALUES(?,?)');

    // Bind the (?) with variables, then execute
    $stmt->bind_param('ss', $nombre, $contr);
    $nombre = 'paco';
    $contr = 'paco';
    $stmt->execute();

    $stmt->bind_param('ss', $nombre, $contr);
    $nombre = 'pepe';
    $contr = 'pepe';
    $stmt->execute();

    // Confirm message
    echo 'Se han insertado 2 usuarios';

    // Closing the statement
    $stmt->close();

    // Closing the database connection
    $conn->cerrarConexion();
?>