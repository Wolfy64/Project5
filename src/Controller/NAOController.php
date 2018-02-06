<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Observation;
use App\Form\ObservationType;


class NAOController extends AbstractController
{
    /**
     * @Route("/", name="homepage") 
     */
    public function homepage(): Response
    {
        return $this->render('NAO/homepage.html.twig',[
            'homepage' => 'Home Page'
        ]);
    }

    /**
     * @Route("/a-propos", name="about") 
     */
    public function about(): Response
    {
        return $this->render('NAO/about.html.twig', [
            'about' => 'A Propos'
        ]);
    }

    /**
     * @Route("/adherer", name="joinUs") 
     */
    public function joinUs(): Response
    {
        return $this->render('NAO/joinUs.html.twig', [
            'joinUs' => 'Adhérer',
        ]);
    }

    /**
     * @Route("/observer", name="observe") 
     */
    public function observe(Request $request): Response
    {
        $observation = new Observation();
        $form = $this->createForm(ObservationType::class, $observation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $observation = $form->getData();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($observation);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('NAO/observe.html.twig', [
            'form' => $form->createView(),
            'observe' => 'Observer'
        ]);
    }

    /**
     * @Route("/list-observations", name="listObservations") 
     */
    public function listObservations(Request $request): Response
    {
        $id = 5;
        $observations = $this->getDoctrine()
            ->getRepository(Observation::class)
            ->findAll();
        dump($observations);
        if (!$observations) {
            throw $this->createNotFoundException(
                'No result'
            );
        }
        return $this->render('NAO/listObservations.html.twig', [
            'listObservations' => 'Liste des observations',
            'observations' => $observations
        ]);
    }

    /**
     * @Route("/carte", name="map") 
     */
    public function map(): Response
    {
        return $this->render('NAO/map.html.twig', [
            'map' => 'Carte'
        ]);
    }

    /**
     * @Route("/blog", name="blog") 
     */
    public function blog(): Response
    {
        return $this->render('NAO/blog.html.twig', [
            'blog' => 'Blog'
        ]);
    }

    /**
     * @Route("/faq", name="faq") 
     */
    public function faq(): Response
    {
        return $this->render('NAO/faq.html.twig', [
            'faq' => 'F.A.Q'
        ]);
    }

    /**
     * @Route("/contact", name="contact") 
     */
    public function contact(): Response
    {
        return $this->render('NAO/contact.html.twig', [
            'contact' => 'Contact'
        ]);
    }

    /**
     * @Route("/admin", name="admin") 
     */
    public function admin(): Response
    {
        return $this->render('NAO/signIn.html.twig', [
            'signIn' => 'Se connecter'
        ]);
    }

    /**
     * @Route("/adhesionFile", name="adhesionFile") 
     */
    public function adhesionFile(): BinaryFileResponse
    {
        return $this->file('files/formulaire_adhésion.pdf');
    }
}