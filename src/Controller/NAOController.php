<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NAOController extends AbstractController
{
    /**
     * @Route("/", name="homepage") 
     */
    public function homepage()
    {
        return $this->render('NAO/homepage.html.twig',[
            'homepage' => 'Home Page'
        ]);
    }

    /**
     * @Route("/about", name="about") 
     */
    public function about()
    {
        return $this->render('NAO/about.html.twig', [
            'about' => 'A Propos'
        ]);
    }

    /**
     * @Route("/joinUs", name="joinUs") 
     */
    public function joinUs()
    {
        return $this->render('NAO/joinUs.html.twig', [
            'joinUs' => 'Adhérer'
        ]);
    }

    /**
     * @Route("/observe", name="observe") 
     */
    public function observe()
    {
        return $this->render('NAO/observe.html.twig', [
            'observe' => 'Observer'
        ]);
    }

    /**
     * @Route("/map", name="map") 
     */
    public function map()
    {
        return $this->render('NAO/map.html.twig', [
            'map' => 'Carte'
        ]);
    }

    /**
     * @Route("/blog", name="blog") 
     */
    public function blog()
    {
        return $this->render('NAO/blog.html.twig', [
            'blog' => 'Blog'
        ]);
    }

    /**
     * @Route("/faq", name="faq") 
     */
    public function faq()
    {
        return $this->render('NAO/faq.html.twig', [
            'faq' => 'F.A.Q'
        ]);
    }

    /**
     * @Route("/contact", name="contact") 
     */
    public function contact()
    {
        return $this->render('NAO/contact.html.twig', [
            'contact' => 'Contact'
        ]);
    }

    /**
     * @Route("/signIn", name="signIn") 
     */
    public function signIn()
    {
        return $this->render('NAO/signIn.html.twig', [
            'signIn' => 'Se connecter'
        ]);
    }
}
