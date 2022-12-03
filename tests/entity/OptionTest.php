<?php

namespace App\Tests\Entity;

use App\Entity\Option;
use PHPUnit\Framework\TestCase;

class OptionTest extends TestCase
{
    public function testIsTrue()
    {
        $option = new Option();
        $option->setLabel('something')
            ->setName('something')
            ->setValue('something')
            ->setType('something');

        $this->assertTrue($option->getLabel(), 'something');
        $this->assertTrue($option->getName(), 'something');
        $this->assertTrue($option->getValue() === 'something');
        $this->assertTrue($option->getType() === 'something');
    }

    public function testIsFalse()
    {
        $option = new Option();
        $option->setLabel('something new')
            ->setName('something new')
            ->setValue('something new')
            ->setType('something new');

        $this->assertFalse($option->getLabel(), 'something');
        $this->assertFalse($option->getName(), 'something');
        $this->assertFalse($option->getValue() === 'something');
        $this->assertFalse($option->getType() === 'something');
    }

    public function testIsEmpty()
    {
        $option = new Option();

        $this->assertEmpty($option->getLabel());
        $this->assertEmpty($option->getName());
        $this->assertEmpty($option->getValue());
        $this->assertEmpty($option->getType());
    }
}
