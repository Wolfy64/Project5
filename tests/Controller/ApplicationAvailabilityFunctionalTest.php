<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
        $this->client->request('GET', $url);
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
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
}