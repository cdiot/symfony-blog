<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private array $users = [];

    private array $medias  = [];

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadMedias($manager);
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

    private function loadMedias(ObjectManager $manager): void
    {
        foreach ($this->getMediaData() as [$name, $filename, $altText, $createdAt, $updatedAt]) {
            $media = new Media();
            $media->setName($name);
            $media->setFilename($filename);
            $media->setAltText($altText);
            $media->setCreatedAt($createdAt);
            $media->setUpdatedAt($updatedAt);
            $manager->persist($media);
            $this->medias[] = $media;
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

    private function getMediaData(): array
    {
        return [
            // $mediaData = [$name, $filename, $altText, $createdAt, $updatedAt];
            [
                'seoul_door_in_night.jpg',
                'seoul_door_in_night.jpg',
                'Séoul une des huit ancienne porte vue de nuit',
                new DateTimeImmutable(),
                new DateTime(),
            ],
        ];
    }
}
