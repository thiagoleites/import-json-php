<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Importação de dados via JSON</title>
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<link href="http://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
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
        <?php
          require 'config.php';

          $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
          if(isset($post['submit']) && !empty($post['submit'])){
            unset($post['submit']);
            $cliente = new Cliente();

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

?>
        <form id="form-data-json" action="" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="json" class="form-label">Selecione um arquivo JSON</label>
            <input class="form-control" type="file" name="jsonFile" id="json" accept=".json">
          </div>
          <div>
            <input id="submit" class="btn btn-primary" name="submit" type="submit" value="Importar">
          </div>
        </form>
      </section>
      <div id="resposta" class="row col-md-8 mx-auto mt-5 mb-3 border rounded p-5">

      </div>
      <section class="row col-md-8 mx-auto mt-5 mb-3 p-5">
        <h2 class="text-muted text-center">Registros inseridos</h2>
        <div class="mt-4">
          <div class="card">
            <div class="table-responsive" id="showClientes">

            </div>
          </div>
        </div>
      </section>
      
    </div>
    
    <!--Modal Editar-->
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
                <form id="form_actions" action="" method="post">
                  <input type="hidden" name="id" id="id">
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
    </div><!--/Close Editar-->
    <!--Modal Excluir-->
    <div class="modal fade" id="modalDelCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Deletar Cliente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row p3">
              <div class="col">
                <form id="form_actions" action="" method="post">
                  <div class="mb-3">
                    Deseja realmente excluir o registro?
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Sim</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Não</button>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!--/Close Excluir-->
  </main>
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
  <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="http://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    
    //Mostrar todos os Clientes
    showAllClientes();
    function showAllClientes() {
      $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: {
          action: 'view'
        },
        success: function(response) {
          $("#showClientes").html(response);
          // $("table").DataTable({ order: [0, 'desc']});
        }
      });
    }

    //Editar formulários
    $("body").on("click", ".editBtn", function(e) {
      e.preventDefault();
      edit_id = $(this).attr('id');

      $.ajax({
        url: "ajax.php",
        type: "POST",
        data: { edit_id: edit_id },
        success: function(response) {
          data = JSON.parse(response);
          // console.log(data)
          $("#id").val(data.id);
          $("#nome").val(data.nome);
          $("#email").val(data.email);
          $("#telefone").val(data.telefone);
        }
      });
    });
    $("#update").click(function(e){
      if($("#form_actions").valid()){
        e.preventDefault();
        $.ajax({
          url: "ajax.php",
          type: "POST",
          data: $("#form_actions").serialize()+"&action=update",
          success: function(response){
            Swal.fire({
              title: 'Atualizado!',
              text: 'Registro atualizado com sucesso!',
              icon: 'success',
              confirmButtonText: 'Fechar'
            })
            $("#modalEditCliente").modal('hide');
            $("#form_actions")[0].reset();
            showAllClientes();
          }
        });
      }
    });

    $("body").on("click", ".delBtn", function(e){
      e.preventDefault();
      console.log("teste del");
    })
  });
</script>
</body>
</html>