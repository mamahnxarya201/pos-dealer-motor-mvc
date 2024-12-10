<?php
declare(strict_types=1);

namespace Controller;

use Router\Attributes\GET;
use Router\Attributes\NeedAuth;

class PageController
{
    #[GET('/')]
    public function login(): void
    {
        require 'src/views/login.php';
    }

    #[NeedAuth]
    #[GET('/home')]
    public function index(): void
    {
        require 'src/views/home.php';
    }

    #[NeedAuth]
    #[GET('/supplier')]
    public function supplier(): void
    {
        require 'src/views/supplier.php';
    }
}