<?php

namespace App\Action;

use App\Domain\User\Service\UserReader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class UserReadAction
{
    
    private $userReader;

   
    public function __construct(UserReader $userReader)
    {
        $this->userReader = $userReader;
    }

    
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
       
        $userId = (int)$args['id'];

        $userData = $this->userReader->getUserDetails($userId);

       
        $result = [
            'user_id' => $userData->id,
            'username' => $userData->username,
            'first_name' => $userData->firstName,
            'last_name' => $userData->lastName,
            'email' => $userData->email,
        ];

      
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
