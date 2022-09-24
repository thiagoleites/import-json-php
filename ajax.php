<?php
// // header('Content-Type: application/json');
// ini_set('default_charset', 'UTF-8');

require 'config.php';

$cliente = new Cliente();

//Mostrar todos na tabela
if(isset($_POST['action']) && $_POST['action'] == 'view') {
  
  $showCliente = $cliente->selectAllClientes('criado_em DESC');

  if(!$showCliente) {
    echo "<h3 class='text-center mt-5 mb-5 text-secondary'>Não há registros no banco!</h3>";
  } else {
    $output = '
    <table class="table">
              <thead class="bg-primary text-white">
                <tr>
                  <th>#</th>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Telefone</th>
                  <th style="width:15%;">Data de cadastro</th>
                  <th class="text-center">Ações</th>
                </tr>
              </thead>
              <tbody>';
    foreach($showCliente as $cliente) {
      extract($cliente);
    $output .='<tr>
                  <td >'. $id . '</td>
                  <td>'. $nome . '</td>
                  <td>'. $email . '</td>
                  <td>'. $telefone . '</td>
                  <td style="width:15%;">'. date('d/m/Y H:i', strtotime($criado_em)) . '</td>
                  <td class="text-center">
                    <a href="#" id="'. $id . '" class="btn btn-outline-info btn-sm editBtn"
                     data-bs-toggle="modal" data-bs-target="#modalEditeCliente">Editar</a>
                    <a href="#" id="'. $id . '" class="btn btn-outline-danger btn-sm delBtn"
                     >Excluir</a>
                  </td>
                </tr>';
    }
                '</tbody>';
    $output .= '</table>';
          echo $output;
  }
}


//Novo cadastro
if(isset($_POST['action']) && $_POST['action'] == 'insert') {
  $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
  unset($dados['action']);
  
  $nome = $dados['nome'];
  $email = $dados['email'];
  $telefone = $dados['telefone'];
  $result = $cliente->insertCliente($dados);

  $message = ($cliente->getMessage());
  echo json_encode($message);
}

//Editar cadastro
if(isset($_POST['edit_id'])) {
  $id = $_POST['edit_id'];
  $result = $cliente->selectCliente($id);
  echo json_encode($result);
}
if(isset($_POST['action']) && $_POST['action'] == 'update') {
  $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
  unset($dados['action']);
  
  $id = $dados['id'];
  $nome = $dados['nome'];
  $email = $dados['email'];
  $telefone = $dados['telefone'];
  $update = date('Y-m-d H:i:s');
  $result = $cliente->updateCliente($id, $nome, $email, $telefone, $update);

  $message = ($cliente->getMessage());
  echo json_encode($message);
}

//Delete cadastro
if(isset($_POST['del_id'])){
  $id = $_POST['del_id'];
  $cliente->deleteCliente($id);

}