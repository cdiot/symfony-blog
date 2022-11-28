<?php

namespace App\Tests\Entity;

use App\Entity\ArticleCategory;
use PHPUnit\Framework\TestCase;

class ArticleCategoryTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new ArticleCategory();
        $user->setName('something')
            ->setSlug('something');

        $this->assertTrue($user->getName() === 'something');
        $this->assertTrue($user->getSlug() === 'something');
    }

    public function testIsFalse()
    {
        $user = new ArticleCategory();
        $user->setName('something new')
            ->setSlug('something new');

        $this->assertFalse($user->getName() === 'something');
        $this->assertFalse($user->getSlug() === 'something');
    }

    public function testIsEmpty()
    {
        $user = new ArticleCategory();

        $this->assertEmpty($user->getName());
        $this->assertEmpty($user->getSlug());
    }
}
