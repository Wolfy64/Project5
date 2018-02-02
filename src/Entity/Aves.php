<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvesRepository")
 */
class Aves
{
    /**
     * * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=25)
     */
    private $ordre;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=25)
     */
    private $famille;

    /**
     * @var string
     * 
     * @ORM\Column(name="lb_name", type="string", length=60)
     */
    private $lbName;

    /**
     * @var string
     * 
     * @ORM\Column(name="lb_auteur", type="string", length=60)
     */
    private $lbAuteur;

    /**
     * @var string
     * 
     * @ORM\Column(name="nom_vern", type="string", length=120)
     */
    private $nomVern;

    /**
     * @var integer
     * 
     * @ORM\Column(type="integer", length=1)
     */
    private $habitat;

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrdre(): string
    {
        return $this->ordre;
    }

    public function setOrdre(string $ordre): void
    {
        $this->ordre;
    }

    public function getFamille(): string
    {
        return $this->famille;
    }

    public function setFamille(string $famille): void
    {
        $this->famille;
    }

    public function getLbName(): string
    {
        return $this->lbName;
    }

    public function setLbName(string $lbName): void
    {
        $this->lbName;
    }

    public function getLbAuteur(): string
    {
        return $this->lbAuteur;
    }

    public function setLbAuteur(string $lbAuteur): void
    {
        $this->lbAuteur;
    }

    public function getNomVern(): string
    {
        return $this->nomVern;
    }

    public function setNomVern(string $nomVern): void
    {
        $this->nomVern;
    }

    public function getHabitat(): int
    {
        return $this->habitat;
    }

    public function setHabitat(int $habitat): void
    {
        $this->habitat;
    }
}