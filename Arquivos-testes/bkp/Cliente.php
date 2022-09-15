<?php

class Cliente {

  private $json_file;
  private $store_data;
  private $number_of_records;
  private $ids = [];
  private $names = [];

  public function __construct($file_path)
  {
    // Path do arquivo JSON
    $this->json_file = $file_path;
    $this->store_data = json_decode(file_get_contents($this->json_file, true));
    $this->number_of_records = count($this->store_data);

    if($this->number_of_records != 0) {

      foreach($this->stored_data as $cliente) {
        array_push($this->ids, $cliente->id);
        array_push($this->names, $cliente->nome);
      }

    }
  }

  private function setClienteId($cliente_id)
  {
    // $this->ids[] = $cliente_id;
    if($this->number_of_records == 0) {
      $cliente_id['id'] = 1;
    } else {
      $cliente_id['id'] = max($this->ids) + 1;
    }

    return $cliente_id;
  }

  private function storeData()
  {
    file_put_contents(
      $this->json_file,
      json_encode($this->store_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
      LOCK_EX
    );
  }

  public function insertNewCliente($new_cliente)
  {
    $this->store_data[] = $new_cliente;
  }

  public function updateCliente($cliente_id, $field, $value)
  {
    $this->store_data[$cliente_id][$field] = $value;
  }

  public function deleteCliente($cliente_id)
  {
    unset($this->store_data[$cliente_id]);
  }

  public function deleteAllClientes()
  {
    $this->store_data = [];
  }
}