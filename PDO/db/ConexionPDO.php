<?php
require_once('config_db.php');

class ConexionPDO
{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $conn;

    public function __construct()
    {
        $this->host = HOST;
        $this->user = USER;
        $this->pass = PASS;
        $this->db = DB;
    }

    public function getConexion()
    {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->db;charset=utf8";
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $this->conn;
    }
    public function closeConexion()
    {
        $this->conn = null;
    }
}