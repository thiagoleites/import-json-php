<?php include 'inc/header.php'; ?>

      <div class="col-6 mx-auto p-5 mt-3 mb-4">
        <h2 class="d-none">Formulário de requisição</h2>
        <form action="" method="post" enctype="multipart/form-data">


          <div class="d-flex gap-1 mb-3">
            <input class="form-control" type="file" name="jsonFile" id="json">
            <input class="btn btn-primary" name="sendFile" type="submit" value="Importar">   
          </div>

          <div id="res_load_file" class="lead text-center py-2">
            <?php
            require 'config.php';

            $cliente = new Cliente();

            if(isset($_POST['sendFile']) && !empty($_POST['sendFile'])) {
              $path = $_FILES['jsonFile']['tmp_name'];

              if(empty($path)){
                echo '<div class="alert alert-danger" role="alert">Selecione um arquivo!</div>';
              } else {
                $data = $cliente->getJson($path);
                $cliente->getData($data);
                echo $cliente->getMessage();
              }
            }
            ?>
          </div>

        </form>
      </div>
        </section>

        <section>
          <h2 class="display-6 text-center mb-5">Registros no banco</h2>
          <div class="text-center">
            <a href="#" id="" class="btn btn-primary btn-sm py-2 px-3 mb-3 addBtn" data-bs-toggle="modal" data-bs-target="#modalNovoCliente">Novo Cliente</a>
          </div>
          
          <div id="showAllClientes" class="table-responsive">
            
          </div>
        </section>
      </div>

<?php include 'inc/footer.php'; ?>