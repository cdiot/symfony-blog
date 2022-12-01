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
            ['123456', 'fry@gmail.com', 'ROLE_ADMIN', 'Fry'],
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

    private function getReportCategoryData(): array
    {
        return [
            // $reportCategoryData = [$name];
            ['L\'image ne s\'affiche pas'],
            ['Orthographe'],
            ['Autre (précisé)'],
        ];
    }

    private function getReportData(): array
    {
        return [
            // $reportData = [$email, $content, $article, $category, $createdAt, $updatedAt];
            ['foo@gmail.com', 'Ce article est incomplet.', 0, 1, new DateTimeImmutable(), new DateTime()],
        ];
    }

    private function getCommentData(): array
    {
        return [
            // $commentData = [$user, $article, $createdAt, $updatedAt, $content];
            [0, 0, new DateTimeImmutable(), new DateTime(), 'Super article!'],
            [1, 0, new DateTimeImmutable(), new DateTime(), 'Génial!'],
            [0, 0, new DateTimeImmutable(), new DateTime(), 'Je vous remercie!'],
        ];
    }
}
