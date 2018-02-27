<?php

namespace App\Entity;

class Newsletter
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getEmail() : ? string
    {
        return $this->email;
    }

    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }
}
