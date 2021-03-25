<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Data\UserReaderData;
use DomainException;
use PDO;


class UserReaderRepository
{
      private $connection;

    
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    
    public function getUserById(int $userId): UserReaderData
    {
        $sql = "SELECT id, username, first_name, last_name, email FROM users WHERE id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $userId]);

        $row = $statement->fetch();

        if (!$row) {
            throw new DomainException(sprintf('User not found: %s', $userId));
        }

  
        $user = new UserReaderData();
        $user->id = (int)$row['id'];
        $user->username = (string)$row['username'];
        $user->firstName = (string)$row['first_name'];
        $user->lastName = (string)$row['last_name'];
        $user->email = (string)$row['email'];

        return $user;
    }
}
