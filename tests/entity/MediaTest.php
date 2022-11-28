<?php

namespace App\Tests\Entity;

use App\Entity\Media;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class MediaTest extends TestCase
{
    public function testIsTrue()
    {
        $media = new Media();
        $createdAt = new DateTimeImmutable();
        $updatedAt = new DateTime();
        $media->setName('something')
            ->setFilename('something')
            ->setAltText('something')
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt);

        $this->assertTrue($media->getName() === 'something');
        $this->assertTrue($media->getFilename() === 'something');
        $this->assertTrue($media->getAltText() === 'something');
        $this->assertTrue($media->getCreatedAt() === $createdAt);
        $this->assertTrue($media->getUpdatedAt() === $updatedAt);
    }

    public function testIsFalse()
    {
        $media = new Media();
        $createdAt = new DateTimeImmutable();
        $createdYesterday = $createdAt->modify('-1 day');
        $updatedAt = new DateTime();
        $media->setName('something new')
            ->setFilename('something new')
            ->setAltText('something new')
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt);

        $this->assertFalse($media->getName() === 'something');
        $this->assertFalse($media->getFilename() === 'something');
        $this->assertFalse($media->getAltText() === 'something');
        $this->assertFalse($createdYesterday === $createdAt);
        $this->assertFalse($media->getUpdatedAt() === new DateTime('2022-12-12 10:00:00'));
    }

    public function testIsEmpty()
    {
        $media = new Media();

        $this->assertEmpty($media->getName());
        $this->assertEmpty($media->getFilename());
        $this->assertEmpty($media->getAltText());
        $this->assertEmpty($media->getCreatedAt());
        $this->assertEmpty($media->getUpdatedAt());
    }
}
