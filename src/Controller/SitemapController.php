<?php

namespace App\Controller;

use App\Repository\ArticleCategoryRepository;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    #[Route('/site-map.xml', name: 'site_map', defaults: [
        '_format' => 'xml',
    ])]
    public function index(Request $request, ArticleRepository $articleRepository, ArticleCategoryRepository $articleCategoryRepository): Response
    {
        $hostname = $request->getSchemeAndHttpHost();

        $urls = [];

        $urls[] = ['loc' => $this->generateUrl('home')];
        $urls[] = ['loc' => $this->generateUrl('article_list')];

        foreach ($articleRepository->findAll() as $article) {
            $illustration = [
                'loc' => '/build/images/' . $article->getFeaturedImage(),
                'title' => $article->getTitle()
            ];

            $urls[] = [
                'loc' => $this->generateUrl('article_show', [
                    'slug' => $article->getSlug(),
                ]),
                'lastmod' => $article->getUpdatedAt()->format('Y-m-d'),
                'image' => $illustration
            ];
        }

        foreach ($articleCategoryRepository->findAll() as $articleCategory) {
            $urls[] = [
                'loc' => $this->generateUrl('article_category_show', [
                    'slug' => $articleCategory->getSlug(),
                ])
            ];
        }

        $response = new Response(
            $this->renderView(
                'sitemap/index.html.twig',
                [
                    'urls' => $urls,
                    'hostname' => $hostname,
                    200
                ]
            )
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
