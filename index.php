<?php

require 'config.php';

$cliente = new Cliente();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Importação de dados via JSON</title>
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>
  <main>
    <class="container">
      <header class="row col-md-8 mx-auto text-center mt-5 border-2 border-bottom">
        <h1 class="display-4 fw-bolder">Importando dados com JSON</h1>
        <p class="text-muted">Arquivo de importação JSON para MySQL</p>
      </header>
      <div class="row col-md-6 mx-auto mt-5 mb-5">

        <div class="load_spin text-center d-none">
          <div class="spinner-grow" style="width: 5rem; height: 5rem;" role="status">
            <span class="visually-hidden">Carregando...</span>
          </div>
        </div>
      </div>
      <section class="row col-md-8 mx-auto mt-5">
        <h2 class="d-none">Formulário de requisição</h2>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="json" class="form-label">Selecione um arquivo JSON</label>
            <input class="form-control" type="file" name="jsonFile" id="json">
          </div>
          <div>
            <input class="btn btn-primary" name="submit" type="submit" value="Importar">
          </div>
        </form>
      </section>
      <div class="row col-md-8 mx-auto mt-5 mb-3 border rounded p-5">

      </div>
      <section class="row col-md-8 mx-auto mt-5 mb-3 r p-5">
        <h2 class="text-muted text-center">Dados do banco</h2>
        <div class="mt-4">
          <div class="card border-bottom-0">
            <div class="table-responsive" id="table-details">
              <table class="table ">
                <tr>
                  <td class="text-center">ID</td>
                  <td>Nome</td>
                  <td>Email</td>
                  <td>Telefone</td>
                  <td>Ações</td>
                </tr>
                <?php // $cliente = new Cliente();

                    $get  = filter_input(INPUT_GET, 'action', FILTER_VALIDATE_INT);
                    $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                    if(isset($post['submit']) && !empty($post['submit'])){
                      unset($post['submit']);

                      $path = $_FILES['jsonFile']['tmp_name'];

                      if(empty($path)){
                        echo "Selecione um arquivo";
                      } else {
                        {
                          $data = $cliente->getJson($path);
                          $cliente->getData($data);
                          echo $cliente->getMessage();
                        } 
                      }
                    } 
                    else {
                      // Seleciono todos os Clientes do banco para mostrar na tabela
                      $showCliente = $cliente->selectAllClientes();
                      if(!$showCliente){
                        echo "Cliente não encontrado";
                      } else {
                        foreach($showCliente as $dados){
                          extract($dados);
                    ?>
                <tr>
                  <td class="text-center"><?= $id; ?></td>
                  <td><?= $nome; ?></td>
                  <td><?= $email; ?></td>
                  <td><?= $telefone; ?></td>
                  <td>
                      <button type="button" data-action="" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditCliente">
                        Editar
                      </button>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="modalDeleteCliente">
                        Excluir
                </td>
                  </tr>
                  <?php
                        }
                      }
                    }
                  ?>
              </table>
            </div>
          </div>
        </div>
      </section>
      
    </div>

    <div class="modal fade" id="modalEditCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Atualizar dados</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row p3">
              <div class="col">
                <?php
                  // $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);


                  /*
                  if(isset($post['update']) && !empty($post['update'])){
                    unset($post['update']);
                    $cliente->updateCliente($post, $id);
                    echo $cliente->getMessage();
                  } */
                ?>
                <form id="form_actions" action="" method="post">
                  <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php if (isset($dados)) echo $dados['nome']; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php if (isset($dados)) echo $dados['email']; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?php if (isset($dados)) echo $dados['telefone']; ?>">
                  </div>
                  <div class="mb-3">
                    <input type="hidden" name="id" id="id">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Atualizar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
  <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<script>

</script>
<script>
  $(function (){
    function load(action){
      var load_div = $('.load_spin');

      if(action === "open") {
        load_div.fadeIn().css('display', 'flex');
      } else {
        load_div.fadeOut();
      }
    }

    $("form[name='form_actions']").submit(function(e){
      e.preventDefault();
      var form = $(this);
      var url = form.attr('action');
      var type = form.attr('method');
      var data = form.serialize();

      $.ajax({
        url: url,
        type: type,
        data: data,
        beforeSend: function(){
          load('open');
        },
        success: function(response){
          load('close');
          $('#modalEditCliente').modal('hide');
          $('#table-details').html(response);
        }
      });
    });
  });
  </script>
  <!-- <script>
    $(document).on("submit", "#saveData", function(e){
      e.preventDefault();
      
      var formData = new FormData(this);
      formData.append("save_cliente", true);

        $.ajax({
          url: "ajax.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function(data){
            $("#table-details").html(data);
          }
        });
      });
      
  </script> -->
</body>
</html>