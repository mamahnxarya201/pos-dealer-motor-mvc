<?php

namespace Controller;

use Model\User;
use Router\Attributes\GET;
use Router\Attributes\POST;
use Router\Attributes\Prefix;

#[Prefix('/api/auth')]
class AuthController
{
    #[POST('/login')]
    public function login()
    {
        $email = (string)$_POST['email'];
        $password = (string)$_POST['password'];


        if ((new User(null, $email, null, $password))->login() === true) {
            http_response_code(200);
            echo json_encode(['message' => 'Login successful']);
            return;
        }
        http_response_code(400);
        echo json_encode(['message' => 'Failed to login']);
    }

    #[POST('/logout')]
    public function logout()
    {

    }

    #[POST('/register')]
    public function register()
    {
        $email = (string)$_POST['email'];
        $password = (string)$_POST['password'];
        $name = (string)$_POST['username'];

        if ((new User(null, $email, $name, $password))->register() === true) {

            http_response_code(200);
            echo json_encode(['message' => 'Registration successful']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to register']);
        }
    }
}