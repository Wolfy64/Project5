<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdhesionFileController extends AbstractController
{
    public function index() : BinaryFileResponse
    {
        return $this->file('files/formulaire_adhésion.pdf');
    }
}
