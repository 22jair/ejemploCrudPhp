<?php
include __DIR__ . '/../config/config.php';
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, PUT, GET, OPTIONS'); 

class Conexion extends Mysqli
{

    private $server = COSNT_SERVER;
    private $dbname = CONST_DBNAME;
    private $user = CONST_USER;
    private $password = CONST_PASSWORD;

    function __construct()
    {
        try {
            parent::__construct($this->server, $this->user, $this->password, $this->dbname);
            $this->set_charset('utf8');
                             
        } catch (Exception $error) {
            die("El error de conexión es: " . $error->getMessage());
        }
    }


}
