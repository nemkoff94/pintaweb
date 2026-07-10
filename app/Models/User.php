<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

final class User
{
    public function __construct(private readonly PDO $connection)
    {
    }

    public function findByLogin(string $login): ?array
    {
        $statement = $this->connection->prepare(
            'SELECT id, login, password_hash FROM users WHERE login = :login LIMIT 1'
        );
        $statement->execute([
            ':login' => $login,
        ]);

        $user = $statement->fetch();

        return is_array($user) ? $user : null;
    }
}
