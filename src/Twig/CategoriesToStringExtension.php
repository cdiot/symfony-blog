<?php

namespace App\Twig;

use App\Entity\ArticleCategory;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CategoriesToStringExtension extends AbstractExtension
{
    public function __construct(
        private RouterInterface $router
    ) {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('categoriesToString', [$this, 'categoriesToString']),
        ];
    }

    public function categoriesToString(Collection $categories): string
    {
        $generateCategoryLink = function (ArticleCategory $category) {

            $url = $this->router->generate('article_category_show', [
                'slug' => $category->getSlug()
            ]);

            return "<a href='$url' title='{$category->getName()}'>{$category->getName()}</a>";
        };

        $categoryLinks = array_map($generateCategoryLink, $categories->toArray());

        return implode(', ', $categoryLinks);
    }
}
