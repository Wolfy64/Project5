<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    const ROLE_USER = ['ROLE_USER'];

    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=25)
     */
    private $firstName;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=25)
     */
    private $lastName;

    /**
     * @var string
     * 
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @var array
     * 
     * @ORM\Column(type="simple_array")
     */
    private $roles = [];

    /**
     * @var boolean
     * 
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var boolean
     */
    private $termsOfUse;

    public function __construct()
    {
        $this->isActive = true;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getSalt(): void
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password): void
    {
        $this->plainPassword = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantees that a user always has at least one role for security
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
        // $roles[] = $this->roles;

        // if (empty($roles)){
        //     $roles[] = self::ROLE_USER;
        // }

        // return $roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getTermsOfUse()
    {
        return $this->termsOfUse;
    }

    public function setTermsOfUse(bool $termsOfUse): void
    {
        $this->termsOfUse = $termsOfUse;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }
}