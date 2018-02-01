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
     * 
     * @Assert\NotBlank()
     * @Assert\Email(checkMX=true)
     */
    private $username;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=25)
     * 
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min = 2, max = 25)
     */
    private $firstName;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=25)
     * 
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=2, max=25)
     */
    private $lastName;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @Assert\Length(min=4,max=100)
     */
    private $plainPassword;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=64)
     */
    private $password;

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
     * 
     * @Assert\IsTrue()
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

    public function getUsername(): ? string
    {
        return $this->username;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function getFirstName(): ? string
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ? string
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

    public function getPlainPassword(): ? string
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

    public function setPassword($password): void
    {
        $this->password = $password;
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

    public function getTermsOfUse(): ? bool
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