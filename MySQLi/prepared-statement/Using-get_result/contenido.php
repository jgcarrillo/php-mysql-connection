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

        // Get a result set from a prepared statement
        $stmt = $query->get_result();

        if($stmt->num_rows > 0){
            // Using fetch to get the result of the statement
            $fila = $stmt->fetch_object();
            $_SESSION['login_user'] = $fila->nombre;
            $_SESSION['pass_user'] = $fila->pass;

            echo 'Bienvenido';
        } else {
            echo '<p>Acceso no autorizado</p>';
            echo '<a href="login.php">[ Conectar ]</a>';
        }
    }
    // Closing connection
    $conn->cerrarConexion();
?>