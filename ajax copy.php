<?php
require 'config.php';

$cliente = new Cliente();

// $get  = filter_input(INPUT_GET, 'action', FILTER_VALIDATE_INT);
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(isset($post['submit']) && !empty($post['submit'])){
  unset($post['submit']);
  echo 'teste';
  die;
  $path = $_FILES['jsonFile']['tmp_name'];

  if(empty($path)){
    echo "Selecione um arquivo";
  } else {
    {
      $data = $cliente->getJson($path);
      sleep(10);
      $cliente->getData($data);
      echo $cliente->getMessage();
    } 
  }
} 
else {
  // Seleciono todos os Clientes do banco para mostrar na tabela
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
                      <a href="edit.php?id='.$id.'" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditCliente">Editar</a>
                      <a href="delete.php?id='.$id.'" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="modalDeleteCliente">Excluir</a>
                    </td>
                  </tr>';
        }
                  $output .= '</table>';
                  echo $output;
  }
}




//  <tr>
//                   <td class="text-center"></td>
//                   <td></td>
//                   <td></td>
//                   <td></td>
//                   <td>
//                       <button type="button" data-action="" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditCliente">
//                         Editar
//                       </button>
//                       <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="modalDeleteCliente">
//                         Excluir
//                 </td>
//                   </tr>
//               </table> 
