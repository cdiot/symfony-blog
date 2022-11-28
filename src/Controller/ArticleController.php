<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'article_list')]
    public function index(
        ArticleRepository $articleRepository
    ): Response {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll()
        ]);
    }

    #[Route('/article/{slug}', name: 'article_show')]
    public function show(
        ?Article $article
    ): Response {
        if (!$article) {
            return $this->redirectToRoute('article_list');
        }

        return $this->renderForm('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
