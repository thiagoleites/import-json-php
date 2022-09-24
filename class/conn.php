<?php

class Conn {

  private $host = "localhost";
  private $user = "root";
  private $pass = "";
  private $db = "envolve";

  public function Connect() {
    try {
      $conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    } catch (PDOException $e) {
      echo "Erro: " . $e->getMessage();
    }
  }
}