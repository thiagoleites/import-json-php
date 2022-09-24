      <div id="modais">
        <!-- Modal Adicao-->
        <div class="modal fade" id="modalNovoCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Novo registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="formsCad" action="" method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label for="Nome" class="form-label">Nome</label>
                    <input type="text" class="form-control py-2" name="nome" placeholder="Digite seu nome" />
                  </div>
                  <div class="mb-3">
                    <label for="Nome" class="form-label">Email</label>
                    <input type="text" class="form-control py-2" name="email" placeholder="examplo@email.com" />
                  </div>
                  <div class="mb-3">
                    <label for="Nome" class="form-label">Telefone</label>
                    <input
                      type="text"
                      class="form-control py-2"
                      name="telefone"
                      placeholder="(99) 99999-9999"
                    />
                  </div>
                  <button id="novoCadastro" class="btn btn-primary" type="submit" name="novoCadastro">Salvar</button>
                </form>
              </div>
              <div class="modal-footer d-flex justify-content-center">
                <p id="response" class="lead text-center py-2 rounded"></p>
              </div>
            </div>
          </div>
        </div>


         <!-- Modal Editar-->
         <div class="modal fade" id="modalEditeCliente" tabindex="-1" aria-labelledby="modalEditeCliente" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Editar registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="formsEdit" action="" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="id" id="id_e">
                  <div class="mb-3">
                    <label for="Nome" class="form-label">Nome</label>
                    <input type="text" id="nome_e" class="form-control py-2" name="nome" placeholder="Digite seu nome" 
                           value="<?php if(isset($dados)) echo $dados['nome'];?>" />
                  </div>
                  <div class="mb-3">
                    <label for="Nome" class="form-label">Email</label>
                    <input type="text" id="email_e" class="form-control py-2" name="email" placeholder="examplo@email.com" 
                           value="<?php if(isset($dados)) echo $dados['email'];?>" />
                  </div>
                  <div class="mb-3">
                    <label for="Nome" class="form-label">Telefone</label>
                    <input type="text" id="tel_e" class="form-control py-2" name="telefone" placeholder="(99) 99999-9999"
                           value="<?php if(isset($dados)) echo $dados['ntelefone'];?>"
                    />
                  </div>
                  <button id="editCadastro" class="btn btn-primary" type="submit" name="editCadastro">Salvar</button>
                </form>
              </div>
              <div class="modal-footer d-flex justify-content-center">
                <p id="response" class="lead text-center py-2 rounded"></p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </main>
    <footer>
      <div class="container my-5 border-top">
          <div class="col-12 text-center p-3">
            <p class="lead text-muted">&copy; 2022 - Importando dados com JSON</p>
          </div>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/ju/dt-1.12.1/datatables.min.js"></script>
    <script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <script>
      $(document).ready(function() {

      //Mostra todos os registros
        showAllClientes();
        function showAllClientes() {
          $.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: { action : 'view'},
            success: function(response) {
              $("#showAllClientes").html(response);
            }
          });
        }

        //Adiciona novo Registro
        $("#novoCadastro").click(function(e) {
          if ($("#formsCad")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
              url: 'ajax.php',
              type: 'POST',
              data: $("#formsCad").serialize() + "&action=insert",
              success: function(response) {
                if(response){
                  $("#response").html(response);
                  $("#formsCad")[0].reset();
                  showAllClientes();
                  $("#modalNovoCliente").modal('hide');
                }else{
                  $("#response").html(response);
                }
              },

            });
          }
        });

        //Edição de dados
        $("body").on("click", ".editBtn", function(e) {
          e.preventDefault();
          edit_id = $(this).attr('id');

          $.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: { edit_id: edit_id },
            success: function(response) {
              data = JSON.parse(response);
              console.log(data);
              $("#id_e").val(data.id);
              $("#nome_e").val(data.nome);
              $("#email_e").val(data.email);
              $("#tel_e").val(data.telefone);
            }
          });
        });
        $("#editCadastro").click(function(e) {
          if ($("#formsEdit")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
              url: 'ajax.php',
              type: 'POST',
              data: $("#formsEdit").serialize() + "&action=update",
              success: function(response) {
                Swal.fire({
                  title: 'Sucesso!',
                  text: 'Registro atualizado com sucesso!',
                  icon: 'success',
                  confirmButtonText: 'Fechar'
                });
                $("#modalEditeCliente").modal('hide');
                showAllClientes();
              }
            });
          }
        });

        //Exclusão de dados
        $("body").on("click", ".delBtn", function(e){
          e.preventDefault();
          var td = $(this).closest('tr');
          del_id = $(this).attr('id');
          Swal.fire({
            title: 'Você tem certeza?',
            text:"Você não poderá reverter isso!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, deletar!'
            }).then((result) => {
              if(result.value) {
                $.ajax({
                  url: 'ajax.php',
                  type: 'POST',
                  data: { del_id: del_id },
                  success: function(response){
                    Swal.fire(
                      'Deletado!',
                      'Seu registro foi deletado.',
                      'success'
                    )
                    showAllClientes();
                  }
                })
              }
            })

          /*$.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: { del_id: del_id },
            success: function(response) {
              data = JSON.parse(response);
              $("#id_d").val(data.id);
              $("#clienteName").text(data.nome);
            }
          }); */
        })
        /*
        $("#deletarCliente").click(function(e){
          $.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: $("#id_d") + "&action=delete",
            success: function(response) {
              console.log(response);
              Swal.fire({
                title: 'Sucesso!',
                text: 'Registro deletado com sucesso!',
                icon: 'success',
                confirmButtonText: 'Fechar'
              });
              $("#modalDeleteCliente").modal('hide');
              showAllClientes();
            }
          })
        }) */

      });
    </script>
  </body>
</html>
