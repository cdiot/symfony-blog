<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReportControllerTest extends WebTestCase
{
    public function testShouldDisplayReportIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/mon-super-premier-article/rapport');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Signaler un problème');
    }
}
