<?php

class Database{

  private $servername = "sql11.freemysqlhosting.net";
  private $username = "sql11205709";
  private $password =  null;
  private $dbname = "sql11205709";
  private $conn = null;

  function __construct(){
    $this->connect();
  }

  private function connect(){
    //$this->password = 'JXXfhRc7EL';
    $this->password = getenv('DBPASSWD_ENV');
    $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
  }

  public function ExecQuery($query){
    return $this->conn->query($query);
  }
}
