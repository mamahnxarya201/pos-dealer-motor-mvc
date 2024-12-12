<?php

namespace Model\Repository;

use Model\User;

class UserRepository
{
// Create a new user
    public static function createUser(PDO $db, string $user_email, string $user_name, string $user_password): bool
    {
        $sql = "INSERT INTO user (user_email, user_name, user_password) VALUES (:user_email, :user_name, :user_password)";
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':user_email' => $user_email,
            ':user_name' => $user_name,
            ':user_password' => password_hash($user_password, PASSWORD_DEFAULT),
        ]);
    }

    // Get user by ID
    public static function getUserById(PDO $db, int $user_id): ?User
    {
        $sql = "SELECT * FROM user WHERE user_id = :user_id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new User($row['user_email'], $row['user_id'], $row['user_name'], $row['user_password']);
        }

        return null;
    }

    // Update user
    public static function updateUser(PDO $db, int $user_id, string $user_email, string $user_name, string $user_password): bool
    {
        $sql = "UPDATE user SET user_email = :user_email, user_name = :user_name, user_password = :user_password WHERE user_id = :user_id";
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':user_id' => $user_id,
            ':user_email' => $user_email,
            ':user_name' => $user_name,
            ':user_password' => password_hash($user_password, PASSWORD_DEFAULT),
        ]);
    }

    // Delete user
    public static function deleteUser(PDO $db, int $user_id): bool
    {
        $sql = "DELETE FROM user WHERE user_id = :user_id";
        $stmt = $db->prepare($sql);

        return $stmt->execute([':user_id' => $user_id]);
    }
}