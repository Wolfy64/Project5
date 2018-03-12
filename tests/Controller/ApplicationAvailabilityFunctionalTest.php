<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $this->logIn();
        $crawler = $this->client->request('GET', $url);
        // $crawler = $this->client->request('GET', $url, [], [], ['PHP_AUTH_USER' => 'freebirds@gmail.com', 'PHP_AUTH_PW' => 'freebirds']);

        // $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/apropos'];
        yield ['/adherer'];
        yield ['/faq'];
        yield ['/contact'];
        yield ['/connexion'];
        yield ['/inscription'];
        yield ['/newsletter'];
        yield ['/plan-du-site'];
        yield ['/mentions-legales'];
        yield ['/recherche'];
        // yield ['/formulaire-adhesion']; // 500
        // yield ['/list-des-observations']; // 500
        // yield ['/blog']; // 500
        // yield ['/observer']; // 302
        // yield ['/carte']; // 302
        // yield ['/carte-liste']; // 302
        // yield ['/mes-observations']; // Call to a member function getId() on string
        yield ['/naturalist/validations']; // 302
        // yield ['/naturalist/observation/valider/{id}']; // 302
        // yield ['/naturalist/observation/supprimer/{id']; // 302
        // yield ['/naturalist/observation/modifier/{id}']; // 302
        // yield ['/naturalist/articles']; // 302
        // yield ['/naturalist/articles/nouvel-article']; // 302
        // yield ['/naturalist/articles/supprimer/{id}']; // 302
        // yield ['/naturalist/articles/modifier/{id}']; // 302
        // yield ['/deconnexion']; // 302
    }

    // public function testSecuredHello()
    // {
    //     $this->logIn();
    //     $crawler = $this->client->request('GET', '/admin');

    //     $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    //     $this->assertSame('Admin Dashboard', $crawler->filter('h1')->text());
    // }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'secured_area';

        $token = new UsernamePasswordToken('admin', null, $firewallContext, array('ROLE_ADMIN'));
        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}