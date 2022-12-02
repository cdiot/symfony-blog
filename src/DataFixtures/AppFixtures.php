<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use App\Entity\Comment;
use App\Entity\Media;
use App\Entity\Report;
use App\Entity\ReportCategory;
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

    private array $reportCategories  = [];

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadMedias($manager);
        $this->loadArticleCategories($manager);
        $this->loadArticles($manager);
        $this->loadReportCategories($manager);
        $this->loadReports($manager);
        $this->loadComments($manager);
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

    private function loadReportCategories(ObjectManager $manager): void
    {
        foreach ($this->getReportCategoryData() as [$name]) {
            $reportCategory = new ReportCategory();
            $reportCategory->setName($name);
            $manager->persist($reportCategory);
            $this->reportCategories[] = $reportCategory;
        }
        $manager->flush();
    }

    private function loadReports(ObjectManager $manager): void
    {
        foreach ($this->getReportData() as [$email, $content, $article, $category, $createdAt, $updatedAt]) {
            $report = new Report();
            $report->setEmail($email);
            $report->setContent($content);
            $report->setCreatedAt($createdAt);
            $report->setUpdatedAt($updatedAt);
            $report->setArticle($this->articles[$article]);
            $report->setCategory($this->reportCategories[$category]);
            $report->setIsClose(false);
            $manager->persist($report);
        }
        $manager->flush();
    }

    private function loadComments(ObjectManager $manager): void
    {
        foreach ($this->getCommentData() as [$user, $article, $createdAt, $updatedAt, $content]) {
            $comment = new Comment();
            $comment->setUser($this->users[$user]);
            $comment->setArticle($this->articles[$article]);
            $comment->setCreatedAt($createdAt);
            $comment->setUpdatedAt($updatedAt);
            $comment->setContent($content);
            $manager->persist($comment);
        }
        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // $userData = [$password, $email, $roles, $username];
            ['123456', 'foobar@gmail.com', 'ROLE_ADMIN', 'Foobar'],
            ['123456', 'foo@gmail.com', 'ROLE_USER', 'Foo'],
            ['123456', 'bar@gmail.com', 'ROLE_USER', 'Bar'],
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
            ['Thailande', 'thailande'],
            ['Corée du sud', 'coree-du-sud'],
            ['Hors série', 'hors-serie'],
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
                'Bonjour le monde!',
                'bonjour-le-monde',
                'Bienvenue sur SymfonyCMSBlog. Ceci est votre premier poste.',
                'La description de votre premier poste sur SymfonyCMSBlog.',
                0,
                1,
            ],
            [
                0,
                new DateTimeImmutable(),
                new DateTime(),
                'Votre deuxième poste',
                'votre-deuxieme-poste',
                'Le texte mise en avant de votre deuxième poste.',
                'La description de votre deuxième poste sur SymfonyCMSBlog.',
                0,
                2,
            ],
            [
                0,
                new DateTimeImmutable(),
                new DateTime(),
                'Votre troisième poste',
                'votre-troisieme-poste',
                'Le texte mise en avant de votre troisième poste.',
                'La description de votre troisième poste sur SymfonyCMSBlog.',
                0,
                0,
            ],
            [
                0,
                new DateTimeImmutable(),
                new DateTime(),
                'Votre quatrième poste',
                'votre-quatrieme-poste',
                'Le texte mise en avant de votre quatrième poste.',
                'La description de votre quatrième poste sur SymfonyCMSBlog.',
                0,
                1,
            ],
            [
                0,
                new DateTimeImmutable(),
                new DateTime(),
                'Votre cinquième poste',
                'votre-cinquieme-poste',
                'Le texte mise en avant de votre cinquième poste.',
                'La description de votre cinquième poste sur SymfonyCMSBlog.',
                0,
                1,
            ],
            [
                0,
                new DateTimeImmutable(),
                new DateTime(),
                'Votre sixième poste',
                'votre-sixieme-poste',
                'Le texte mise en avant de votre sixième poste.',
                'La description de votre sixième poste sur SymfonyCMSBlog.',
                0,
                2,
            ],
            [
                0,
                new DateTimeImmutable(),
                new DateTime(),
                'Votre septième poste',
                'votre-septieme-poste',
                'Le texte mise en avant de votre septième poste.',
                'La description de votre septième poste sur SymfonyCMSBlog.',
                0,
                2,
            ],
        ];
    }

    private function getReportCategoryData(): array
    {
        return [
            // $reportCategoryData = [$name];
            ['Lien mort'],
            ['Autre (précisé)'],
        ];
    }

    private function getReportData(): array
    {
        return [
            // $reportData = [$email, $content, $article, $category, $createdAt, $updatedAt];
            ['foo@gmail.com', 'Hi, This is a report.', 0, 1, new DateTimeImmutable(), new DateTime()],
        ];
    }

    private function getCommentData(): array
    {
        return [
            // $commentData = [$user, $article, $createdAt, $updatedAt, $content];
            [1, 0, new DateTimeImmutable(), new DateTime(), 'Bonjour, ceci est un commentaire.'],
        ];
    }
}
