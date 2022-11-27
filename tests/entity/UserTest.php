<?php

namespace App\Tests\Entity;

use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new User();
        $createdAt = new DateTimeImmutable();
        $updatedAt = new DateTime();
        $user->setEmail('foo@test.com')
            ->setPassword('123456')
            ->setRoles(['ROLE_USER'])
            ->setUsername('something')
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt)
            ->setIsVerified(true);

        $this->assertTrue($user->getEmail() === 'foo@test.com');
        $this->assertTrue($user->getPassword() === '123456');
        $this->assertTrue($user->getRoles() === ['ROLE_USER']);
        $this->assertTrue($user->getUsername() === 'something');
        $this->assertTrue($user->getCreatedAt() === $createdAt);
        $this->assertTrue($user->getUpdatedAt() === $updatedAt);
        $this->assertTrue($user->isVerified() === true);
    }

    public function testIsFalse()
    {
        $user = new User();
        $createdAt = new DateTimeImmutable();
        $createdYesterday = $createdAt->modify('-1 day');
        $updatedAt = new DateTime();
        $user->setEmail('bar@test.com')
            ->setPassword('azerty')
            ->setRoles(['ROLE_ADMIN'])
            ->setUsername('something new')
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt)
            ->setIsVerified(false);

        $this->assertFalse($user->getEmail() === 'foo@test.com');
        $this->assertFalse($user->getPassword() === '123456');
        $this->assertFalse($user->getRoles() === ['ROLE_USER']);
        $this->assertFalse($user->getUsername() === 'something');
        $this->assertFalse($createdYesterday === $createdAt);
        $this->assertFalse($user->getUpdatedAt() === new DateTime('2022-12-12 10:00:00'));
        $this->assertFalse($user->isVerified() === true);
    }

    public function testIsEmpty()
    {
        $user = new User();
        $user->setPassword('');

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getPassword());
        $this->assertEmpty($user->getUsername());
        $this->assertEmpty($user->getCreatedAt());
        $this->assertEmpty($user->getUpdatedAt());
        $this->assertEmpty($user->isVerified());
    }
}
