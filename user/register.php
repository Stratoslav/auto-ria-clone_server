<?php

function createTable($connection){
      $usersTableQuery = mysqli_query($connection, "CREATE TABLE IF NOT EXISTS `users` (
             `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
             `name` VARCHAR(255) NOT NULL,
             `surname` VARCHAR (255) NOT NULL,
             `email` VARCHAR (255) NOT NULL UNIQUE
        )");
   
}
function createUser($data, $connection)
{
    createTable($connection);
    $name = htmlspecialchars(($data['name']));
    $surname = htmlspecialchars($data['surname']);
    $email = htmlspecialchars($data['email']);
    $user = mysqli_query($connection, "SELECT * FROM `users` WHERE `email` = '$email'");
    $result = mysqli_fetch_assoc($user);
    if (strlen($name) < 2 || strlen($surname) < 2) {
        $res = [
            "status" => false,
            "message" => "name and surname length must be at least 2 symbols",
        ];
        echo json_encode($res);
        exit();
    }

    if ((!empty($result))) {
        $res = [
            "status" => false,
            "message" => "User with such email already exist",
        ];
        echo json_encode($res);
        exit();
    }
    $stmt = mysqli_prepare($connection, "INSERT INTO `users` (`id`, `name`, `surname`, `email`) VALUES (NULL, ?, ?, ?)");

    mysqli_stmt_bind_param($stmt, 'sss', $name, $surname, $email);
    mysqli_stmt_execute($stmt);



    http_response_code(201);
    $res = [
        "status" => true,
        "message" => "successful",
    ];
    echo json_encode($res);
}

function login($connection, $data){
    $name = htmlspecialchars($data['name']);
    $email = htmlspecialchars($data['email']);
    $user = mysqli_query($connection, "SELECT * FROM `users` WHERE `name` = '$name' AND `email` = '$email'");
  $result = mysqli_fetch_assoc($user);
  
if(empty($result)){
    
    $res = [
      
'status' => false,
"message" => "User with sush name or email doesn't exist"
    ];
   echo json_encode($res);
}else {
        http_response_code(200);
      $res = [
'status' => true,
"message" => "access",
"user" => $result
    ];
        
   echo json_encode($res);
}
    
}