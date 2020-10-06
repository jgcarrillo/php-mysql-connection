<?php
require_once('config_db.php');

class ConexionMYSQL {

    private $host;
    private $user;
    private $pass;
    private $db;
    private $conn;

    public function __construct() {
        $this->host = HOST;
        $this->user = USER;
        $this->pass = PASS;
        $this->db = DB;
    }

    public function crearConexion() : object {
        @$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if($this->conn->connect_errno) {
            die("Error al conectarse a Mysql: $this->conn->connect_error");
        }

        return $this->conn;
    }

    public function cerrarConexion() {
        $this->conn->close();
    }
}

?>