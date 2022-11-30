<?php

namespace App\Tests\Entity;

use App\Entity\ReportCategory;
use PHPUnit\Framework\TestCase;

class ReportCategoryTest extends TestCase
{
    public function testIsTrue()
    {
        $reportCategory = new ReportCategory();
        $reportCategory->setName('something');

        $this->assertTrue($reportCategory->getName() === 'something');
    }

    public function testIsFalse()
    {
        $reportCategory = new ReportCategory();
        $reportCategory->setName('something new');

        $this->assertFalse($reportCategory->getName() === 'something');
    }

    public function testIsEmpty()
    {
        $reportCategory = new ReportCategory();

        $this->assertEmpty($reportCategory->getName());
    }
}
