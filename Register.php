<?php 
    require_once __DIR__ . "/models/User.php";
    require_once __DIR__ . "/repositories/UserRepository.php";
    require_once __DIR__ . "/services/Database.php";
    $name = $_POST['name'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User($name, $lastName, $email, $password);
    $db = new Database();
    $userRepository = new UserRepository($db);
    $result = $userRepository->saveNew($user);
    if ($result->isSuccess()) {
        header("Location: /login.php");
    } else {
        //retornar status code 
        http_response_code($result->getStatus());
        echo $result->getJson();

    }

?>