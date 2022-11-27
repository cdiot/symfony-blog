<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResetPasswordControllerTest extends WebTestCase
{
    public function testShouldDisplayRequestResetPassword(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/mot-de-passe/demande-de-reinitialisation');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mot de passe oublié ?');
    }
}
