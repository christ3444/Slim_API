<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserReaderData;
use App\Domain\User\Repository\UserReaderRepository;
use App\Exception\ValidationException;


final class UserReader
{

    private $repository;


    public function __construct(UserReaderRepository $repository)
    {
        $this->repository = $repository;
    }


    public function getUserDetails(int $userId): UserReaderData
    {
    
        if (empty($userId)) {
            throw new ValidationException('User ID required');
        }

        $user = $this->repository->getUserById($userId);

        return $user;
    }
}