<?php

namespace Controller;

use Router\Attributes\GET;
use Router\Attributes\POST;
use Router\Attributes\Prefix;

#[Prefix('/api/auth')]
class AuthController
{
    #[POST('/login')]
    public function login()
    {

    }

    #[POST('/logout')]
    public function logout()
    {

    }

    #[POST('/register')]
    public function register()
    {

    }
}