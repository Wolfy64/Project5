<?php

namespace App\Service;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\Form;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Naturalist\ModifyObservationType;
use App\Form\MapType;
use App\Form\ObservationType;
use App\Service\FileUploader;
use App\Entity\Observation;

class ObservationService
{
    const NOT_FOUND = 'Cette observation n\'existe pas';
    const HABITAT = [
        1 => 'Marin',
        2 => 'Eau douce',
        3 => 'Terrestre',
        4 => 'Marin & Eau douce',
        5 => 'Marin & Terrestre',
        6 => 'Eau saumâtre',
        7 => 'Continental (terrestre et/ou eau douce)',
        8 => 'Continental (terrestre et/ou eau douce)'
    ];
    const ROLES = [
        'ROLE_ADMIN',
        'ROLE_NATURALIST'
    ];

    private $em;
    private $form;
    private $fileUploader;
    private $observation;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $form, FileUploader $fileUploader, TokenStorageInterface $token)
    {
        $this->em = $em;
        $this->form = $form;
        $this->fileUploader = $fileUploader;
        $this->token = $token;
        $this->observation = new Observation();
    }

    public function observeForm($request) : Form
    {
        $observation = $this->observation;

        $form = $this->form->create(ObservationType::class, $observation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->token->getToken()->getUser();

            $observation->setUser($user);
            $observation->setIsValid(false);
            $observation->setImage('no_image.png');
           
            // If True setIsValid(true)
            $this->isNaturalist(); 

            $file = $form['image']->getData();

            if ($file){
                $fileName = $this->fileUploader->upload($file);
                $observation->setImage($fileName);
            }
            
            $this->persist($observation);
        }

        return $form;
    }

    public function isNaturalist() : bool
    {
        $userRoles = $this->token->getToken()->getUser()->getRoles()[0];

        // If Role = Admin or Naturalist obsersation is valid;
        if (in_array($userRoles, self::ROLES)) {
            $this->observation->setIsValid(true);
            return true;
        }

        return false;
    }

    public function mapForm($request) : Form
    {
        $observation = new Observation();

        $form = $this->form->create(MapType::class, $observation);
        $form->handleRequest($request);

        return $form;
    }

    public function modifyForm(Observation $observation, $request) : Form
    {
        $form = $this->form->create(ModifyObservationType::class, $observation);
        $form->handleRequest($request);

        return $form;
    }

    public function find(int $id) : ?  Observation
    {
        return $this->em->getRepository(Observation::class)->find($id);
    }

    public function findByCommonName(string $commonName) : array
    {
        return $this->em->getRepository(Observation::class)->findBy([
            'commonName' => $commonName,
            'isValid' => true,
        ]);
    }

    public function isPublished(bool $bool) : array
    {
        return $this->em->getRepository(Observation::class)->findBy(['isValid' => $bool]);
    }

    public function doValid(Observation $observation) : void
    {
        $observation->setIsValid(true);
        $this->persist($observation);
    }

    public function doRemove(Observation $observation) : void
    {
        $this->em->remove($observation);
        $this->em->flush();
    }

    public function persist(Observation $observation) : void
    {
        $this->em->persist($observation);
        $this->em->flush();
    }

    public function birdInfos(array $observations) : array
    {
        $birdInfos = [];

        $scientificNames = [];
        $authors = [];

        $aveses = $observations[0]->getAveses();

        // Define $habitat
        switch ($aveses[0]->getHabitat()) {
            case '1':
                $habitat = self::HABITAT[1];
                break;
            case '2':
                $habitat = self::HABITAT[2];
                break;
            case '3':
                $habitat = self::HABITAT[3];
                break;
            case '4':
                $habitat = self::HABITAT[4];
                break;
            case '5':
                $habitat = self::HABITAT[5];
                break;
            case '6':
                $habitat = self::HABITAT[6];
                break;
            case '7':
                $habitat = self::HABITAT[7];
                break;
            case '8':
                $habitat = self::HABITAT[8];
                break;
            
            default:
                $habitat = 'Non déterminé';
                break;
        }

        // Fill up $scientificNames[] & $authors[]
        foreach ($aveses as $aves) {
            $scientificNames[] = $aves->getScientificName();
            
            // Remove brackets
            $author = str_replace(['(', ')'], '', $aves->getAuthor());

            // Avoid duplicate author
            if (!in_array($author, $authors)) {
                $authors[] = $author;
            }
        }

        $birdInfos['order'] = $aveses[0]->getOrder();
        $birdInfos['family'] = $aveses[0]->getFamily();
        $birdInfos['commonName'] = $aveses[0]->getCommonName();
        $birdInfos['habitat'] = $habitat;
        $birdInfos['scientificNames'] = $scientificNames;
        $birdInfos['author'] = $authors;

        return $birdInfos;
    }

    public function findByUser(bool $isValid) : array
    {
        return $this->em->getRepository(Observation::class)->findBy([
            'user' => $this->token->getToken()->getUser()->getId(),
            'isValid' => $isValid,
        ]);
    }
}