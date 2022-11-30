<?php

namespace App\Tests\Entity;

use App\Entity\Report;
use App\Entity\ReportCategory;
use App\Entity\Article;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ReportTest extends TestCase
{
    public function testIsTrue()
    {
        $report = new Report();
        $article = new Article();
        $reportCategory = new ReportCategory();
        $createdAt = new DateTimeImmutable();
        $updatedAt = new DateTime();
        $report->setEmail('something')
            ->setContent('something')
            ->setArticle($article)
            ->setCategory($reportCategory)
            ->setIsClose(true)
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt);

        $this->assertTrue($report->getEmail() === 'something');
        $this->assertTrue($report->getContent() === 'something');
        $this->assertSame($article, $report->getArticle());
        $this->assertSame($reportCategory, $report->getCategory());
        $this->assertTrue($report->isClose() === true);
        $this->assertTrue($report->getCreatedAt() === $createdAt);
        $this->assertTrue($report->getUpdatedAt() === $updatedAt);
    }

    public function testIsFalse()
    {
        $report = new Report();
        $article = new Article();
        $reportCategory = new ReportCategory();
        $createdAt = new DateTimeImmutable();
        $createdYesterday = $createdAt->modify('-1 day');
        $updatedAt = new DateTime();
        $report->setEmail('something new')
            ->setContent('something new')
            ->setArticle($article)
            ->setCategory($reportCategory)
            ->setIsClose(false)
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt);

        $this->assertFalse($report->getEmail() === 'something');
        $this->assertFalse($report->getContent() === 'something');
        $this->assertNotSame(new Article(), $report->getArticle());
        $this->assertNotSame(new ReportCategory(), $report->getCategory());
        $this->assertFalse($report->isClose() === true);
        $this->assertFalse($createdYesterday === $createdAt);
        $this->assertFalse($report->getUpdatedAt() === new DateTime('2022-10-11 10:00:00'));
    }

    public function testIsEmpty()
    {
        $report = new Report();

        $this->assertEmpty($report->getEmail());
        $this->assertEmpty($report->getContent());
        $this->assertEmpty($report->getArticle());
        $this->assertEmpty($report->getCategory());
        $this->assertEmpty($report->isClose());
        $this->assertEmpty($report->getCreatedAt());
        $this->assertEmpty($report->getUpdatedAt());
    }
}
