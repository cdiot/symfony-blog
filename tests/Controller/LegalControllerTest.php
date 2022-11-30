<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LegalControllerTest extends WebTestCase
{
    public function testShouldDisplayPrivacy(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/politique-de-confidentialite');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Politique de confidentialité');
    }

    public function testShouldDisplayTerms(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/conditions-generales-utilisation');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Conditions générales d\'utilisation');
    }
}
