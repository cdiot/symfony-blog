<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use App\Entity\Media;
use App\Entity\Option;
use App\Entity\Report;
use App\Entity\ReportCategory;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\ReportRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        protected ArticleRepository $articleRepository,
        protected UserRepository $userRepository,
        protected CommentRepository $commentRepository,
        protected ReportRepository $reportRepository
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'countAllArticle' => $this->articleRepository->countByAllArticle(),
            'countAllUser' => $this->userRepository->countAllUser(),
            'lastComments' => $this->commentRepository->findLast(),
            'reportsInProgress' => $this->reportRepository->findAll(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ryokosan.com');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-undo', 'home');
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::subMenu('Articles', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Tous les articles', 'fas fa-newspaper', Article::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Article::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Catégories', 'fas fa-list', ArticleCategory::class)
        ]);
        yield MenuItem::subMenu('Médias', 'fas fa-photo-video')->setSubItems([
            MenuItem::linkToCrud('Médiathèque', 'fas fa-photo-video', Media::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Media::class)->setAction(Crud::PAGE_NEW),
        ]);
        yield MenuItem::subMenu('Rapports', 'fas fa-file')->setSubItems([
            MenuItem::linkToCrud('Tous les rapports', 'fas fa-file', Report::class),
            MenuItem::linkToCrud('Catégories des rapports', 'fas fa-list', ReportCategory::class)
        ]);
        yield MenuItem::subMenu('Comptes', 'fas fa-user')->setSubItems([
            MenuItem::linkToCrud('Tous les comptes', 'fas fa-user-friends', User::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW)
        ]);
        yield MenuItem::subMenu('Réglages', 'fas fa-cog')->setSubItems([
            MenuItem::linkToCrud('Général', 'fas fa-cog', Option::class),
        ]);
    }
}
