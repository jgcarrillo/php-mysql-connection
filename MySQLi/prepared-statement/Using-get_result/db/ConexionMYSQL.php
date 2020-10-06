<?php
// Importación de los valores para la conexión desde otro archivo
require_once('config_db.php');

// Clase que almacena la conexión para ser reutilizada
class ConexionMYSQL {

    // Variables de clase que almacenarán los datos de la configuración de la bd
    private $host;
    private $user;
    private $pass;
    private $db;
    private $conn;

    // Constructor que inicializa la conexión con los datos de la bd
    public function __construct() {
        $this->host = HOST;
        $this->user = USER;
        $this->pass = PASS;
        $this->db = DB;
    }

    // Método para establecer conexión por medio de MySQLi
    public function crearConexion() : object {
        @$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if($this->conn->connect_errno) {
            die("Error al conectarse a Mysql: $this->conn->connect_error");
        }

        return $this->conn;
    }

    // Método para cerrar la conexión
    public function cerrarConexion() {
        $this->conn->close();
    }
}

?>