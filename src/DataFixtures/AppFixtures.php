<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private array $users = [];

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$password, $email, $roles, $username]) {
            $user = new User();
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
            $user->setEmail($email);
            $user->setRoles([$roles]);
            $user->setCreatedAt(new DateTimeImmutable());
            $user->setUpdatedAt(new DateTime());
            $user->setIsVerified(true);
            $user->setUsername($username);
            $manager->persist($user);
            $this->users[] = $user;
        }
        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // $userData = [$password, $email, $roles, $username];
            ['123456', 'fry@gmail.com', 'ROLE_ADMIN', 'Fry'],
        ];
    }
}
