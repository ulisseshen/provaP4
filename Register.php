<?php 
    $name = $_POST['name'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User($name, $lastName, $email, $password);
    $db = 
    $userRepository = new UserRepository($db);
    $userRepository->save($user);

?>