<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObservationRepository")
 * @Vich\Uploadable
 */
class Observation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $species;

    /**
     * @var date
     * 
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $town;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $latitude;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $longitude;

    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $numbers;

    /**
     * @var File
     * 
     * @Vich\UploadableField(mapping="observations_image", fileNameProperty="imageName", size="imageSize")
     */
    private $imageFile;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */    
    private $imageName;

    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $imageSize;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $content;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSpecies(): ? string
    {
        return $this->species;
    }

    public function setSpecies($species): void
    {
        $this->species = $species;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getTown(): ? string
    {
        return $this->town;
    }

    public function setTown($town): void
    {
        $this->town = $town;
    }

    public function getLatitude(): ? int
    {
        return $this->latitude;
    }

    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): ? int
    {
        return $this->longitude;
    }

    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getNumbers(): ? int
    {
        return $this->numbers;
    }

    public function getImageFile() : ? File
    {
        return $this->imageFile;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(? File $image = null) : void
    {
        $this->imageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function setNumbers($numbers): void
    {
        $this->numbers = $numbers;
    }

    public function getImageName(): ? string
    {
        return $this->imageName;
    }

    public function setImageName(? string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function setImageSize(? int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ? int
    {
        return $this->imageSize;
    }

    public function getImage():? File
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getContent(): ? string
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }
}
