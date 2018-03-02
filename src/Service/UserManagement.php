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

    public function getUser()
    {
        return $this->token->getToken()->getUser();
    }

    public function getRole()
    {
        if ($this->getUser() != 'anon.'){
            return $this->getUser()->getRoles()[0];
        }

        return 'ANNONYME';
    }

    public function getFirstName()
    {
        return $this->getUser()->getFirstName();
    }

    public function getLastName()
    {
        return $this->getUser()->getLastName();
    }
}