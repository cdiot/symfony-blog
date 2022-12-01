<?php

namespace App\Tests\Entity;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testIsTrue()
    {
        $comment = new Comment();
        $user = new User();
        $article = new Article();
        $createdAt = new DateTimeImmutable();
        $updatedAt = new DateTime();
        $comment->setUser($user)
            ->setArticle($article)
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt)
            ->setContent('something');

        $this->assertSame($user, $comment->getUser());
        $this->assertSame($article, $comment->getArticle());
        $this->assertTrue($comment->getCreatedAt() === $createdAt);
        $this->assertTrue($comment->getUpdatedAt() === $updatedAt);
        $this->assertTrue($comment->getContent() === 'something');
    }

    public function testIsFalse()
    {
        $comment = new Comment();
        $user = new User();
        $article = new Article();
        $createdAt = new DateTimeImmutable();
        $createdYesterday = $createdAt->modify('-1 day');
        $updatedAt = new DateTime();
        $comment->setUser($user)
            ->setArticle($article)
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt)
            ->setContent('something new');

        $this->assertNotSame(new User(), $comment->getUser());
        $this->assertNotSame(new Article(), $comment->getArticle());
        $this->assertFalse($createdYesterday === $createdAt);
        $this->assertFalse($comment->getUpdatedAt() === new DateTime('2022-10-11 10:00:00'));
        $this->assertFalse($comment->getContent() === 'something');
    }

    public function testIsEmpty()
    {
        $comment = new Comment();

        $this->assertEmpty($comment->getUser());
        $this->assertEmpty($comment->getArticle());
        $this->assertEmpty($comment->getCreatedAt());
        $this->assertEmpty($comment->getUpdatedAt());
        $this->assertEmpty($comment->getContent());
    }
}
