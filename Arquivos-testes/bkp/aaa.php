<?php

class Clientes
{

  private $nome;
  private $telefone;
  private $endereco;

  public function __construct($nome, $telefone, $endereco)
  {
    $this->nome = $nome;
    $this->telefone = $telefone;
    $this->endereco = $endereco;

    $this->insert();
  }

  public function getNome()
  {
    return $this->nome;
  }

  public function getTelefone()
  {
    return $this->telefone;
  }

  public function getEndereco()
  {
    return $this->endereco;
  }

  public function setNome($nome)
  {
    $this->nome = $nome;
  }

  public function setTelefone($telefone)
  {
    $this->telefone = $telefone;
  }

  public function setEndereco($endereco)
  {
    $this->endereco = $endereco;
  }

  public function insert()
  {
    $query = "INSERT INTO clientes (nome, telefone, endereco) VALUES (:nome, :telefone, :endereco)";
    $stmt = Conn::getConn()->prepare($query);
    $stmt->bindValue(':nome', $this->getNome());
    $stmt->bindValue(':telefone', $this->getTelefone());
    $stmt->bindValue(':endereco', $this->getEndereco());
    $stmt->execute();
  }



}