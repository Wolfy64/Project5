<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $object;

    /**
     * @var string
     */
    private $message;

    public function getId(): ? int
    {
        return $this->id;
    }

    public function getFirstName() : ? string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName) : void
    {
        $this->firstName = $firstName;
    }

    public function getLastName() : ? string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName) : void
    {
        $this->lastName = $lastName;
    }

    public function getEmail() : ? string
    {
        return $this->email;
    }

    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    public function getObject() : ? string
    {
        return $this->object;
    }

    public function setObject(string $object) : void
    {
        $this->object = $object;
    }

    public function getMessage() : ? string
    {
        return $this->message;
    }

    public function setMessage(string $message) : void
    {
        $this->message = $message;
    }
}
