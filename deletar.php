<?php
    require_once __DIR__ . "/models/User.php";
    require_once __DIR__ . "/repositories/UserRepository.php";
    require_once __DIR__ . "/services/Database.php";
// Verifica se o parâmetro de consulta 'id' está presente
if (isset($_GET['id'])) {
    // Obtém o ID do parâmetro de consulta
    $id = $_GET['id'];

    $db = new Database();
    $userRepository = new UserRepository($db);
    $user = $userRepository->deleteUser($id);
        header("Location: ./home.php");

    
    

} else {
    echo "ID do usuário não fornecido";
}
?>