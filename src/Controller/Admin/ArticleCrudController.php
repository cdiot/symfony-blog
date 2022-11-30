<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $viewArticle = Action::new('viewArticle', "Voir l'article")
            ->setHtmlAttributes([
                'target' => '_blank'
            ])
            ->linkToCrudAction('viewArticle');

        return $actions
            ->add(Crud::PAGE_EDIT, $viewArticle)
            ->add(Crud::PAGE_INDEX, $viewArticle);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user', 'Auteur'),
            TextField::new('title', 'Titre'),
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('title'),
            TextField::new('leadText', 'Texte en avant'),
            CodeEditorField::new('description', 'Description'),
            DateTimeField::new('createdAt', 'Créé le'),
            DateTimeField::new('updatedAt', 'Mis à jour le'),
            AssociationField::new('featuredImage', 'Image mis en avant'),
            AssociationField::new('categories', 'Les catégories'),
            BooleanField::new('isPublish', 'Est publier')
        ];
    }

    public function viewArticle(AdminContext $context): Response
    {
        /** @var Article $article */
        $article = $context->getEntity()->getInstance();

        return $this->redirectToRoute('app_article_show', [
            'slug' => $article->getSlug()
        ]);
    }
}
