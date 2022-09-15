<?php
require 'config.php';

$cliente = new Cliente();

if(isset($_POST['action']) && $_POST['action'] == "view"){
  // Seleciona todos os Clientes do banco para mostrar na tabela
  $showCliente = $cliente->selectAllClientes();
  if(!$showCliente){
    echo "<h3 class='text-center text-secondary mt-5 mb-5'>Não há registros de clientes ainda!</h3>";
  } else {
    $output = '<table class="table">
                <tr>
                  <td class="text-center">ID</td>
                  <td>Nome</td>
                  <td>Email</td>
                  <td>Telefone</td>
                  <td>Ações</td>
                </tr>';
    foreach($showCliente as $dados){
      extract($dados);
      $output .= '<tr>
                    <td class="text-center">'.$id.'</td>
                    <td>'.$nome.'</td>
                    <td>'.$email.'</td>
                    <td>'.$telefone.'</td>
                    <td>
                      <a href="#" id="'. $id. '" class="btn btn-primary btn-sm editBtn" data-bs-toggle="modal" data-bs-target="#modalEditCliente">Editar</a>
                      <a href="#" id="'. $id. '" class="btn btn-danger btn-sm delBtn" data-bs-toggle="modal" data-bs-target="#modalDelCliente">Excluir</a>
                    </td>
                  </tr>';
        }
                  $output .= '</table>';
                  echo $output;
  }
}

if(isset($_POST['edit_id'])){
  $id = $_POST['edit_id'];
  
  $data = $cliente->selectCliente($id);

  echo json_encode($data);
  /*$nome = $_POST['nome'];
  $email = $_POST['email'];
  $update = date('Y-m-d H:i:s');
  $telefone = $_POST['telefone'];
  $cliente->updateCliente($id, $nome, $email, $telefone, $update);
  echo $cliente->getMessage();*/
}

if(isset($_POST['action']) && $_POST['action'] == "delete"){
  $id = $_POST['id'];
  $cliente->deleteCliente($id);
  echo $cliente->getMessage();
}