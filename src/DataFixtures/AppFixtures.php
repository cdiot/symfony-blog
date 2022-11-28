<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ArticleCategory;
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

    private array $articleCategories  = [];

    private array $articles  = [];

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadMedias($manager);
        $this->loadArticleCategories($manager);
        $this->loadArticles($manager);
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

    private function loadArticleCategories(ObjectManager $manager): void
    {
        foreach ($this->getArticleCategoryData() as [$name, $slug]) {
            $articleCategory = new ArticleCategory();
            $articleCategory->setName($name);
            $articleCategory->setSlug($slug);
            $manager->persist($articleCategory);
            $this->articleCategories[] = $articleCategory;
        }
        $manager->flush();
    }

    private function loadArticles(ObjectManager $manager): void
    {
        foreach ($this->getArticleData() as [$user, $createdAt, $updatedAt, $title, $slug, $leadText, $description, $featuredImage, $category]) {
            $article = new Article();
            $article->setUser($this->users[$user]);
            $article->setCreatedAt($createdAt);
            $article->setUpdatedAt($updatedAt);
            $article->setTitle($title);
            $article->setSlug($slug);
            $article->setLeadText($leadText);
            $article->setDescription($description);
            $article->setFeaturedImage($this->medias[$featuredImage]);
            $article->addCategory($this->articleCategories[$category]);
            $article->setIsPublish(true);
            $article->setIsPopular(true);
            $manager->persist($article);
            $this->articles[] = $article;
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

    private function getArticleCategoryData(): array
    {
        return [
            // $articleCategoryData = [$name, $slug];
            ['Japon', 'japon'],
            ['Thailande', 'thailande'],
            ['Corée du sud', 'coree-du-sud'],
        ];
    }

    private function getArticleData(): array
    {
        return [
            // $articleData = [$user, $createdAt, $updatedAt, $title, $slug, $leadText, $description, $featuredImage, $category];
            [
                0,
                new DateTimeImmutable(),
                new DateTime(),
                'Mon super premier article',
                'mon-super-premier-article',
                'Le texte mise en avant de mon super premier article.',
                'La description très détaille de mon super premier article.',
                0,
                0,
            ],
        ];
    }
}
