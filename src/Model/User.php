<?php
declare(strict_types=1);

namespace Model;

use Database\ConnectionPDO;
use PDO;

class User
{
    public function __construct(
        public ?int    $id,
        public string  $email,
        public ?string $name,
        public string  $password
    )
    {
    }

    public function login(): bool
    {
        $stmt = ConnectionPDO::connect()->prepare("SELECT * FROM user WHERE user_email = :email and user_password = :password");
        $stmt->execute([
            'email' => $this->email,
            'password' => $this->password
        ]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($data)) {
            $_SESSION = [
                'id' => $this->id,
                'email' => $this->email,
                'name' => $data['user_name'],
            ];
            return true;
        }
        return false;
    }

    public function register(): bool
    {
        $stmt = ConnectionPDO::connect()->prepare("INSERT INTO user (user_email, user_name, user_password) VALUES (:email, :name, :password)");
        $success = $stmt->execute(['email' => $this->email, 'name' => $this->name, 'password' => $this->password]);
        if ($success) {
            $this->id = intval(ConnectionPDO::connect()->lastInsertId());
            $_SESSION = [
                'id' => $this->id,
                'email' => $this->email,
                'name' => $this->name,
            ];
            return true;
        }
        return false;
    }
}

