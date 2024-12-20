<?php
declare(strict_types=1);

namespace Controller;

use Model\Motor;
use Model\Order;
use Model\Supplier;
use Router\Attributes\GET;
use Router\Attributes\NeedAuth;

class PageController
{
    #[GET('/')]
    public function login(): void
    {
        require 'src/views/login.php';
    }

    #[GET('/logout')]
    public function logOut(): void
    {
        session_destroy();
        header('Location: /');
        die();
    }

    #[GET('/register')]
    public function register(): void
    {
        require 'src/views/register.php';
    }

    // ga sempet woakakw
//    #[NeedAuth]
//    #[GET('/home')]
//    public function index(): void
//    {
//        require 'src/views/home.php';
//    }

    #[NeedAuth]
    #[GET('/supplier')]
    public function supplier(): void
    {
        $listSupplier = Supplier::getAll();
        require 'src/views/supplier.php';
    }

    #[NeedAuth]
    #[GET('/motor')]
    public function motor(): void
    {
        $listMotor = Motor::getAll();
        require 'src/views/motor.php';
    }

    #[NeedAuth]
    #[GET('/order')]
    public function order(): void
    {
        $listOrder = Order::getAll();
        require 'src/views/order.php';
    }
}