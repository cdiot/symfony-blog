<?php

namespace App\Tests\Controller;

use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testShouldDisplayRegister(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/inscription');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'S\'inscrire');
    }

    public function testShouldSubmitRegisterForm()
    {
        $client = static::createClient();
        $client->request('GET', '/inscription');
        $client->submitForm('S\'inscrire', [
            'registration_form[username]' => 'something',
            'registration_form[email]' => 'foo123@gmail.com',
            'registration_form[plainPassword]' => '123456',
            'registration_form[agreeTerms]' => true,
        ]);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
}
