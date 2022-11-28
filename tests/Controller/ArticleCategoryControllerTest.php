<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleCategoryControllerTest extends WebTestCase
{
    public function testShouldDisplayArticleCategory(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/categorie/japon');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Catégorie Japon');
    }
}
