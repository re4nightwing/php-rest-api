<?php
class Database{
  //DB params
  private $host = 'localhost';
  private $db_name = 'myblog';
  private $username = 'dulan';
  private $password = 'good';
  private $conn;

  public function connect(){
      $this->conn = null;

      try{
        $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e){
        echo 'Conn error: '. $e->getMessage();
      }

      return $this->conn;
  }
}