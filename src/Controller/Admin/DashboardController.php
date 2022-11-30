<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\ArticleRepository;
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
        protected ReportRepository $reportRepository
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'countAllArticle' => $this->articleRepository->countByAllArticle(),
            'countAllUser' => $this->userRepository->countAllUser(),
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
        yield MenuItem::subMenu('Comptes', 'fas fa-user')->setSubItems([
            MenuItem::linkToCrud('Tous les comptes', 'fas fa-user-friends', User::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW)
        ]);
    }
}
