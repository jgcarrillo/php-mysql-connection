<?php 
    require_once('db/ConexionPDO.php');

    // Database connection
    $pdo = new ConexionPDO();
    $dbh = $pdo->getConexion();

    // Insert values into database using prepared statement
    $stmt = $dbh->prepare('INSERT INTO ejercicio10_usuarios(nombre, pass) VALUES (?, ?)');

    // Bind the (?) with variables, then execute
    $nombre = 'paco';
    $pass = 'paco';
    $stmt->bindParam(1, $nombre);
    $stmt->bindParam(2, $pass);
    $stmt->execute();

    $nombre = 'pepe';
    $pass = 'pepe';
    $stmt->bindParam(1, $nombre);
    $stmt->bindParam(2, $pass);
    $stmt->execute();

    // Confirm message
    echo 'Se han insertado 2 usuarios';
?>