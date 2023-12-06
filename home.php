<?php
  require_once __DIR__ . "/models/User.php";
  require_once __DIR__ . "/repositories/UserRepository.php";
  require_once __DIR__ . "/services/Database.php";

  $db = new Database();
  $userRepository = new UserRepository($db);
  $usuarios = $userRepository->getUsers();

  // Verifica se o formulário de edição foi submetido
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];

    // atualiza o usuário
    $userRepository->updateUser($id, $nome, $sobrenome);
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Lista de Usuários</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="d-flex align-items-center">
    <h1>Lista de Usuários</h1> 
    <a href="register.html" class="btn btn-primary">Adicionar Usuário</a>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Sobrenome</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $usuario): ?>
        <tr>
          <td><?php echo $usuario->getId(); ?></td>
          <td><?php echo $usuario->getName(); ?></td>
          <td><?php echo $usuario->getLastName(); ?></td>
          <td>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarModal" data-id="<?php echo $usuario->getId(); ?>" data-nome="<?php echo $usuario->getName(); ?>" data-sobrenome="<?php echo $usuario->getLastName(); ?>">
              Editar
            </button>
            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarExclusaoModal" data-id="<?php echo $usuario->getId(); ?>">Deletar</a>

            <!-- Modal -->
            <div class="modal fade" id="confirmarExclusaoModal" tabindex="-1" aria-labelledby="confirmarExclusaoModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="confirmarExclusaoModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>Deseja realmente excluir este usuário?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="confirmarExclusaoLink" href="#" class="btn btn-danger">Excluir</a>
                  </div>
                </div>
              </div>
            </div>

            <script>
              var confirmarExclusaoModal = document.getElementById('confirmarExclusaoModal');
              confirmarExclusaoModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var confirmarExclusaoLink = document.getElementById('confirmarExclusaoLink');
                confirmarExclusaoLink.href = "./deletar.php?id=" + id;
              });
            </script>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Modal -->
  <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editarModalLabel">Editar Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="">
            <input type="hidden" id="editId" name="id">
            <div class="mb-3">
              <label for="editNome" class="form-label">Nome</label>
              <input type="text" class="form-control" id="editNome" name="nome">
            </div>
            <div class="mb-3">
              <label for="editSobrenome" class="form-label">Sobrenome</label>
              <input type="text" class="form-control" id="editSobrenome" name="sobrenome">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    var editarModal = document.getElementById('editarModal');
    editarModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var id = button.getAttribute('data-id');
      var nome = button.getAttribute('data-nome');
      var sobrenome = button.getAttribute('data-sobrenome');

      var editId = document.getElementById('editId');
      var editNome = document.getElementById('editNome');
      var editSobrenome = document.getElementById('editSobrenome');

      editId.value = id;
      editNome.value = nome;
      editSobrenome.value = sobrenome;
    });
  </script>

  


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
