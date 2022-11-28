<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testShouldDisplayArticleIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/articles');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Tous les articles');
    }

    public function testShouldDisplayOneArticle(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article/mon-super-premier-article');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon super premier article');
    }
}
