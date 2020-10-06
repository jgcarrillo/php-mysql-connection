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

        // Prepared statement to check if user and pass are in the database
        $query = $db->prepare("SELECT * FROM ejercicio10_usuarios WHERE nombre = ? AND pass = ?");
        $query->bind_param('ss', $u, $p); // Podría haberle pasado $nombreEnviado y $passEnviada
        $u = $nombreEnviado;
        $p = $passEnviada;
        $query->execute();

        // Using bind_result to bind variables to a prepared statement for result storage
        // I need to include id because query returns this value.
        $query->bind_result($id, $nom, $con);

        // We can check at that point for null values if we want
        if(($u) == null || ($p) == null){
            echo 'Revisa los valores introducidos, no pueden estar vacíos';
        }

        // Fetch the result and storage it into a $_SESSION
        if($query->fetch()){
            $_SESSION['login_user'] = $nom;
            $_SESSION['pass_user'] = $con;

            echo 'Bienvenido';
        } else {
            echo '<p>Acceso no autorizado</p>';
            echo '<a href="login.php">[ Conectar ]</a>';
        }
    }
?>