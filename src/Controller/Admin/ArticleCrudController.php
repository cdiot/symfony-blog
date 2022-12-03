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
            ->add(Crud::PAGE_INDEX, $viewArticle)
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle(Crud::PAGE_INDEX, 'Articles');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            SlugField::new('slug', 'Permalien')
                ->setTargetFieldName('title')
                ->hideOnIndex(),
            AssociationField::new('user', 'Auteur')
                ->hideOnForm(),
            AssociationField::new('featuredImage', 'Image mis en avant'),
            TextField::new('leadText', 'Texte en avant')
                ->hideOnIndex(),
            CodeEditorField::new('description', 'Description')
                ->hideOnIndex(),
            AssociationField::new('categories', 'Les catégories'),
            DateTimeField::new('createdAt', 'Créé le')
                ->hideOnIndex(),
            DateTimeField::new('updatedAt', 'Mis à jour le'),
            BooleanField::new('isPublish', 'Est publier'),
            BooleanField::new('isPopular', 'Est populaire')
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
