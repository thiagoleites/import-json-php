<?php

class Conn {

  private $host = "localhost";
  private $user = "root";
  private $pass = "";
  private $db = "envolve";

  public function Connect() {
    try {
      $conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    } catch (PDOException $e) {
      echo "Erro: " . $e->getMessage();
    }
  }
}