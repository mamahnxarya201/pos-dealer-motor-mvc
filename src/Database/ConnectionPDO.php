<?php

declare(strict_types=1);

namespace Database;

use Exception;
use PDO;
use PDOException;

class ConnectionPDO
{
    private static ?PDO $db = null;

    public static function connect(): PDO
    {
        if (self::$db === null) {
            try {
                $user = 'root';
                $pass = 'root';
                self::$db = PDO::connect('mysql:host=127.0.0.1;dbname=pos_system', $user, $pass);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                throw new Exception("Error from database connection: " . $e->getMessage());
            } catch(Exception $e) {
                throw new Exception("Unknown error: " . $e->getMessage());
            }
        }

        return self::$db;
    }

    public static function disconnect(): void
    {
        self::$db = null;
    }
}
