<?php
require '_app/config.php';
if($_GET['editar']) {
  $id = $_GET['editar'];
  $query = "SELECT * FROM clientes WHERE id = {$id}";
  $stmt = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($stmt);
  ?>
  <div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-labelledby="modal-editar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-editar">Editar cliente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="action.php" method="POST">
            <div class="form-group">
              <label for="nome">Nome</label>
              <input type="text" name="nome" id="nome" class="form-control" value="<?= $row['nome'];?>">
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control" value="<?= $row['email'];?>">
            </div>
            <div class="form-group">
              <label for="telefone">Telefone</label>
              <input type="text" name="telefone" id="telefone" class="form-control" value="<?= $row['telefone'];?>">
            </div>
            <input type="hidden" name="id" value="<?= $row['id'];?>">
            <button type="submit" name="editar" class="btn btn-primary">Editar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php
  
}