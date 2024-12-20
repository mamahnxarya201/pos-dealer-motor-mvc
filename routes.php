<?php

declare(strict_types=1);

use Controller\ApiController;
use Controller\AuthController;
use Controller\PageController;
use Router\RouteBootstrap;

$controllerClass = [
    PageController::class,
    AuthController::class,
    ApiController::class,
];

(new RouteBootstrap($controllerClass))
    ->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);