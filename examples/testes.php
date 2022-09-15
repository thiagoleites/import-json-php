<?php
require 'conn.php';
// $connect = new PDO("mysql:host=localhost;dbname=envolve", "root", "");

class Cliente extends Conn {

  private $table = "clientes";
  private $data;
  // private $result;
  private $jFile;
  public function getData() {
    return $this->data;
  }
  public function __construct() {
    $this->data = array();
    $this->result = array();
  }

  public function create($table, array $data){
    // $this->data = $data;
    $fields = implode(', ', array_keys($this->data));
    $values = ":'".implode("', '", $this->data)."'";

    $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$values})";

    // $sql = "INSERT INTO {$this->table} (nome, email, telefone) VALUES (:nome, :email, :telefone)";
    // $stmt = Conn::connect()->prepare($sql);
    // $stmt->bindParam(':nome', $this->nome);
    // $stmt->bindParam(':email', $this->email);
    // $stmt->bindParam(':telefone', $this->telefone);
    // return $stmt->execute();

    var_dump($sql);
  }

  public function select() {
    $sql = "SELECT * FROM {$this->table}";
    $stmt = $this->connect()->query($sql);
    while ($row = $stmt->fetch()) {
      echo $row['nome'] . "<br>";
    }
  }

  public function delete(){
    $sql = "DELETE FROM {$this->table} WHERE id = :id";
    $stmt = Conn::connect()->prepare($sql);
    $stmt->bindParam(':id', $this->id);
    return $stmt->execute();
  }

}

$dados = json_decode(file_get_contents('../clientes.json') ,true);
$cliente = new Cliente();

$cliente->create('clientes',$dados);




?>


  <form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="jsonFile">
    <input type="submit" name="submit" value="Enviar">
  </form>
