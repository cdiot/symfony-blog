<?php

namespace App\Tests\Entity;

use App\Entity\Article;
use App\Entity\Media;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testIsTrue()
    {
        $article = new Article();
        $user = new User();
        $media = new Media();
        $createdAt = new DateTimeImmutable();
        $updatedAt = new DateTime();
        $article->setUser($user)
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt)
            ->setTitle('something')
            ->setSlug('something')
            ->setLeadText('something')
            ->setDescription('something')
            ->setFeaturedImage($media)
            ->setIsPublish(true)
            ->setIsPopular(true);

        $this->assertSame($user, $article->getUser());
        $this->assertTrue($article->getCreatedAt() === $createdAt);
        $this->assertTrue($article->getUpdatedAt() === $updatedAt);
        $this->assertTrue($article->getTitle() === 'something');
        $this->assertTrue($article->getSlug() === 'something');
        $this->assertTrue($article->getLeadText() === 'something');
        $this->assertTrue($article->getDescription() === 'something');
        $this->assertSame($media, $article->getFeaturedImage());
        $this->assertTrue($article->isPublish() === true);
        $this->assertTrue($article->isPopular() === true);
    }

    public function testIsFalse()
    {
        $article = new Article();
        $user = new User();
        $media = new Media();
        $createdAt = new DateTimeImmutable();
        $createdYesterday = $createdAt->modify('-1 day');
        $updatedAt = new DateTime();
        $article->setUser($user)
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt)
            ->setTitle('something new')
            ->setSlug('something new')
            ->setLeadText('something new')
            ->setDescription('something new')
            ->setFeaturedImage($media)
            ->setIsPublish(false)
            ->setIsPopular(false);

        $this->assertNotSame($article->getUser(), new User());
        $this->assertFalse($createdYesterday === $createdAt);
        $this->assertFalse($article->getUpdatedAt() === new DateTime('2022-12-12 10:00:00'));
        $this->assertFalse($article->getTitle() === 'something');
        $this->assertFalse($article->getSlug() === 'something');
        $this->assertFalse($article->getLeadText() === 'something');
        $this->assertFalse($article->getDescription() === 'something');
        $this->assertNotSame($article->getFeaturedImage(), new Media());
        $this->assertFalse($article->isPublish() === true);
        $this->assertFalse($article->isPopular() === true);
    }

    public function testIsEmpty()
    {
        $article = new Article();

        $this->assertEmpty($article->getUser());
        $this->assertEmpty($article->getCreatedAt());
        $this->assertEmpty($article->getUpdatedAt());
        $this->assertEmpty($article->getTitle());
        $this->assertEmpty($article->getSlug());
        $this->assertEmpty($article->getLeadText());
        $this->assertEmpty($article->getDescription());
        $this->assertEmpty($article->getFeaturedImage());
        $this->assertEmpty($article->isPublish());
        $this->assertEmpty($article->isPopular());
    }
}
