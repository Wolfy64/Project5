<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObservationRepository")
 * @Vich\Uploadable
 */
class Observation
{
    const NUMBERS_OF_BIRDS = [
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8,
            '9' => 9,
            '10+' => 10
    ];

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
     * 
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min = 2, max = 50)
     */
    private $species;

    /**
     * @var date
     * 
     * @ORM\Column(type="date")
     * 
     * @Assert\Date()
     * @Assert\LessThanOrEqual("today")
     */
    private $date;

    /**
     * @var string
     * 
     * @Assert\Type("string")
     * @Assert\Length(max = 50)
     */
    private $place;

    /**
     * @var float
     * 
     * @ORM\Column(type="float")
     * 
     * @Assert\NotBlank()
     * @Assert\Type("numeric")
     */
    private $latitude;

    /**
     * @var float
     * 
     * @ORM\Column(type="float")
     * 
     * @Assert\NotBlank()
     * @Assert\Type("numeric")
     */
    private $longitude;

    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     * 
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @Assert\Range(min = 1,max = 10)
     */
    private $numbers;

    /**
     * @var File
     * 
     * @Vich\UploadableField(mapping="observations_image", fileNameProperty="imageName", size="imageSize")
     * 
     * @Assert\Image(
     *     maxSize = "3M",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/png"},
     *     minWidth = 200,
     *     maxWidth = 400,
     *     minHeight = 200,
     *     maxHeight = 400
     * )
     */
    private $imageFile;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */    
    private $imageName;

    /**
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $imageSize;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var string
     * 
     * @ORM\Column(type="string",nullable=true)
     * 
     * @Assert\Type("string")
     * @Assert\Length(max = 500)
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

    public function getPlace(): ? string
    {
        return $this->place;
    }

    public function setPlace($place): void
    {
        $this->place = $place;
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
