<?php
declare(strict_types=1);

namespace Model;
class User
{
    public function __construct(
        public int    $id,
        public string $email,
        public string $name,
        public string $password
    )
    {
        $this->password = password_hash($this->password, PASSWORD_ARGON2I);
    }


}

