<?php

namespace Router;

class MiddlewareProcessesor
{
    public static function checkSession(): void
    {
        if (!isset($_SESSION['username'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            header('Location: /');
            exit();
        }
    }
}