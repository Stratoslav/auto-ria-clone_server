<?php

// namespace model;

class DataBase {
    private static $instance = null;
    private $connection;

    public function __construct(){
        // require_once "../config.php";

        $host = DB_HOST;
        $user = DB_USER;
        $pass = DB_PASS;
        $name = DB_NAME;
        $port = DB_PORT;

        $dsn = "mysql:host=$host;dbname=$name;port=$port";
        try{
  $this->connection = new \PDO($dsn, $user, $pass);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        }catch(\PDOException $e){
              die("Database connection failed: " . $e->getMessage());
        }
          }

    public static function getInstance(){
if(!isset(self::$instance)){
            self::$instance = new self();
}
        return self::$instance;
    }
    public function getConnection(){
        return $this->connection;
    }
}