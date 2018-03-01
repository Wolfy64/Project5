<?php

namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserManagement
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function getRole()
    {
        $role = 'ANNONYME';
        $user = $this->token->getToken()->getUser();

        if ($user != 'anon.') {
            $role = $user->getRoles()[0];
        }
        
        return $role;
    }

    //public function getFirstName()
    //{
     //   return $this->token->getToken()->getUser()->getFirstName();
    //}

    public function getLastName()
    {
        return $this->token->getToken()->getUser()->getLastName();
    }
}