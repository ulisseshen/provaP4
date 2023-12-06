<?php
    require_once __DIR__ . "/models/User.php";
    require_once __DIR__ . "/repositories/UserRepository.php";
    require_once __DIR__ . "/services/Database.php";

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados pelo cliente
    $email = $_POST['email'];
    $senha = $_POST['password'];

    $db = new Database();
    $userRepository = new UserRepository($db);
    $user = $userRepository->findByEmail($email);
    if(!$user) {
        header('HTTP/1.1 401 Unauthorized');
        echo 'Email ou senha inválidos';
        exit();
    }

    if(!($senha == $user->getPassword())) {
        header('HTTP/1.1 401 Unauthorized');
        echo 'Email ou senha inválidos';
        exit();
    }

    //criar sessão
    session_start();
    $_SESSION['email'] = $email;

    $response = [
        'success' => true,
        'message' => 'Login realizado com sucesso!'
    ];

    // Retorna a resposta como JSON
    header('Content-Type: application/json');
    header('Location: ./home.php');
    echo json_encode($response);
} else {
    // Retorna um erro caso o método da requisição não seja POST
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Método não permitido';
}
