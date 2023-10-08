<?php

class AuthController
{
    public function login($data)
    {
        $name = htmlspecialchars($data['name']);
        $email = htmlspecialchars($data['email']);
        if (
            strlen($name) == 0 || strlen($email) == 0
        ) {
            $res = [
                'status' => false,
                "message" => "Name and Email required"
            ];

            echo json_encode($res);
            exit();
        }
        $model = new AuthModel();
        $model->login($name, $email);
    }
    public function register($data)
    {
        $name = htmlspecialchars(($data['name']));
        $surname = htmlspecialchars($data['surname']);
        $email = htmlspecialchars($data['email']);

        if (strlen($name) < 2 || strlen($surname) < 2) {
            $res = [
                "status" => false,
                "message" => "name and surname length must be at least 2 symbols",
            ];
            echo json_encode($res);
            exit();
        }
        $model = new AuthModel();
        $model->register($email, $name, $surname);
    }
}