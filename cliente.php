<?php

class Cliente 
{
    private $table = "clientes";

    private $jsonFile;

    private $message;

    private $id;

    private $email;

    public $conn;

    public function __construct()
    {
    }

    // Retorna mensagens
    public function getMessage(){
      return $this->message;
    }
    
    // Retorna o id do cliente
    public function getId(){
      return $this->id;
    }

    /**
     * Tratamento do arquivo JSON através do input do formulário
     * @param mixed $id
     */
    public function getJson($file_path){
      $this->jsonFile = $file_path;
      $json = file_get_contents($this->jsonFile);
      $data = json_decode($json, true);
      return $data;
      // $this->getData($data); //Descomentado para teste
    }

    /**
     * Converte o objeto em array
     * @param array $data
     * @return void
     * 
     */
    public function getData($data){
      foreach ($data as $key => $value) {
        foreach($value as $k => $v){
          $this->$k = $v;
          $this->insertData($v);
        }
      }
    }

    /**
     * Verifica se o email já existe no banco de dados
     * @param $data
     * @return bool
     */
    public function verificaEmail($email) {
      $conn = new Conn();
      $this->email = $email;
      $sql = "SELECT email FROM {$this->table} WHERE email = '{$email}'";
      $result = $conn->Connect()->query($sql);
      if ($result->rowCount() >= 1) {
        $this->message = "Email já cadastrado";
        return false;
      } else {
        return true;
      }
    }

    /**
     * Insere os dados no banco
     * @param $data
     */
    public function insertData($dados){
      $connect = new Conn();
      $dados['data_criacao'] = date('Y-m-d H:i:s');

      if ($this->verificaEmail($dados['email'])) {
        $sql = "INSERT INTO {$this->table} (nome, email, telefone, criado_em) VALUES ('{$dados['nome']}', '{$dados['email']}', '{$dados['telefone']}', '{$dados['data_criacao']}')";
        $result = $connect->Connect()->query($sql);
        if ($result) {
          $this->message = "Dados inseridos com sucesso";
          $this->id = $connect->Connect()->lastInsertId();
        } else {
          $this->message = "Erro ao inserir dados";
        }
      }
    }

    /**
     * Retorna os dados de todos os clientes
     * @param $id
     * @return array
     */
    public function selectAllClientes(){
      $conn = new Conn();
      $sql = "SELECT * FROM {$this->table}";
      $result = $conn->Connect()->query($sql);
      if ($result->rowCount() >= 1) {
        $dados = $result->fetchAll(PDO::FETCH_ASSOC);
        return $dados;
      } else {
        return false;
      }
    }

    /**
     * Retorna os dados do cliente
     * @param $id
     * @return array
     */
    public function selectCliente($id){
      $conn = new Conn();
      $this->id = $id;
      $sql = "SELECT * FROM {$this->table} WHERE id = '{$this->id}'";
      $result = $conn->Connect()->query($sql);
      if ($result->rowCount() >= 1) {
        $this->message = "Cliente encontrado";
        return $result->fetch(PDO::FETCH_ASSOC);
      } else {
        $this->message = "Cliente não encontrado";
        return false;
      }
    }

    /**
     * Atualização dos dados do Cliente
     * @return mixed
     */
    public function updateData($id){
      $this->id = $id;
      $dataUpdate = date('Y-m-d H:i:s');
      $connect = new Conn();
      $sql = "UPDATE {$this->table} SET nome = '{$this->nome}', email = '{$this->email}', telefone = '{$this->telefone}', atualizado_em = {$dataUpdate} WHERE id = '{$this->id}'";
      $result = $connect->Connect()->query($sql);
      if ($result) {
        $this->message = "Dados atualizados com sucesso";
      } else {
        $this->message = "Erro ao atualizar dados";
      }
    }

    public function deleteData($id){
      $this->id = $id;
      $connect = new Conn();
      $sql = "DELETE FROM {$this->table} WHERE id = '{$this->id}'";
      $result = $connect->Connect()->query($sql);
      if ($result) {
        $this->message = "Dados excluídos com sucesso";
      } else {
        $this->message = "Erro ao excluir dados";
      }
    }
}



