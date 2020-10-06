<?php
    require_once('db/ConexionPDO.php');

    // Database connection
    $pdo = new ConexionPDO();
    $dbh = $pdo->getConexion();

    session_start();

    if(isset($_POST['login'])){

        // Get users data from POST
        $nombreEnviado = trim($_POST['usuario']);
        $passEnviada = trim($_POST['pass']);

        // Prepared statement to check if user and pass are in the database
        $stmt = $dbh->prepare("SELECT * FROM ejercicio10_usuarios WHERE nombre = ? AND pass = ?");
        $nombre = $nombreEnviado;
        $pass = $passEnviada;
        $stmt->bindParam(1, $nombre);
        $stmt->bindParam(2, $pass);

        $stmt->execute();

        // Use FETCH_OBJ to use object properties
        if($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $_SESSION['login_user'] = $row->nombre;
            $_SESSION['pass_user'] = $row->pass;

            echo 'Bienvenido';
        } else {
            echo '<p>Acceso no autorizado</p>';
            echo '<a href="login.php">[ Conectar ]</a>';
        }
    }
?>