<?php

class AuthModel
{

    private $db;
    public function __construct()
    {
        $this->db = DataBase::getInstance()->getConnection();

        try {
            $res = $this->db->query("SELECT 1 FROM `users` LIMIT 1");
        } catch (\PDOException $e) {
            $this->createTable();
        }
    }
    public function createTable()
    {
        $usersTableQuery = $this->db->query("CREATE TABLE IF NOT EXISTS `users` (
             `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
             `name` VARCHAR(255) NOT NULL,
             `surname` VARCHAR (255) NOT NULL,
             `email` VARCHAR (255) NOT NULL UNIQUE
        )");
        $usersTableQuery->execute();
    }
    public function login($name, $email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `name` = ? AND `email` = ?");
            $stmt->execute([$name, $email]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (empty($result)) {

                $res = [

                    'status' => false,
                    "message" => "User with sush name or email doesn't exist"
                ];
                echo json_encode($res);
            } else {
                http_response_code(200);
                $res = [
                    'status' => true,
                    "message" => "access",
                    "user" => $result
                ];

                echo json_encode($res);
            }
        } catch (\PDOException $e) {
            echo $e;
        }

    }
    function register($email, $name, $surname)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `email` = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ((!empty($user))) {
                $res = [
                    "status" => false,
                    "message" => "User with such email already exist",
                ];
                echo json_encode($res);
                exit();
            }

            $stmt2 = $this->db->prepare("INSERT INTO `users` (`id`, `name`, `surname`, `email`) VALUES (NULL, ?, ?, ?)");

            $stmt2->execute([$name, $surname, $email]);


            http_response_code(201);
            $res = [
                "status" => true,
                "message" => "successful",
            ];
            echo json_encode($res);
        } catch (\PDOException $e) {
            echo $e;
        }

    }

}