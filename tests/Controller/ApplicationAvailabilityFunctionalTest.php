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

        $this->assertTrue($this->client->getResponse()->isSuccessful(), 'response status is 2xx');
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
        // yield ['/naturalist/validations']; // 302
        // yield ['/naturalist/observation/valider/{id}']; // 302
        // yield ['/naturalist/observation/supprimer/{id']; // 302
        // yield ['/naturalist/observation/modifier/{id}']; // 302
        // yield ['/naturalist/articles']; // 302
        // yield ['/naturalist/articles/nouvel-article']; // 302
        // yield ['/naturalist/articles/supprimer/{id}']; // 302
        // yield ['/naturalist/articles/modifier/{id}']; // 302
        // yield ['/deconnexion']; // 302
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'secured_area';

        $token = new UsernamePasswordToken('admin', null, $firewallContext, array('ROLE_NATURALIST'));
        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}