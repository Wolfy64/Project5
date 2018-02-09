<?php

namespace App\Entity;

class Aves
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $ordre;

    /**
     * @var string
     */
    private $famille;

    /**
     * @var string
     */
    private $lbName;

    /**
     * @var string
     */
    private $lbAuteur;

    /**
     * @var string
     */
    private $nomVern;

    /**
     * @var integer
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