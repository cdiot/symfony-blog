<?php

namespace App\Controller;

use App\Entity\ArticleCategory;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleCategoryController extends AbstractController
{
    #[Route('/categorie/{slug}', name: 'article_category_show')]
    public function show(
        ?ArticleCategory $articleCategory,
        ArticleRepository $articleRepository
    ): Response {
        if (!$articleCategory) {
            return $this->redirectToRoute('article_list');
        }

        return $this->render('article_category/index.html.twig', [
            'category' => $articleCategory,
            'articles' => $articleRepository->findAll()
        ]);
    }
}
