<?php
    require_once('db/ConexionMYSQL.php');

    // Database connection
    $conn = new ConexionMYSQL();
    $db = $conn->crearConexion();
    $db->set_charset('utf8');

    session_start();

    if(isset($_POST['login'])){

        // Get users data from POST
        $nombreEnviado = trim($_POST['usuario']);
        $passEnviada = trim($_POST['pass']);

        // Check if user and password into database using query
        $stmt = $db->query("SELECT * FROM ejercicio10_usuarios WHERE nombre = '$nombreEnviado' AND pass = '$passEnviada'");

        // True if the statement return a row. Then store user and password inside $_SESSION array
        if($stmt->num_rows > 0){
            $_SESSION['login_user'] = $nombreEnviado;
            $_SESSION['pass_user'] = $passEnviada;

            // Free memory
            $stmt->free();

            echo 'Bienvenido';
        } else {
            echo '<p>Acceso no autorizado</p>';
            echo '<a href="login.php">[ Conectar ]</a>';
        }
    }
    // Closing connection
    $conn->cerrarConexion();
?>