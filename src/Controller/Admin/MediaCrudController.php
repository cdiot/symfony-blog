<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * @method User getUser()
 */
class MediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom');

        $imageField = ImageField::new('filename', 'Média')
            ->setBasePath('build/images/')
            ->setUploadDir('public/build/images')
            ->setUploadedFileNamePattern('[name].[extension]');
        if (Crud::PAGE_EDIT == $pageName) {
            $imageField->setRequired(false);
        }

        yield $imageField;
        yield TextField::new('altTExt', 'Texte alternatif');
        yield DateTimeField::new('createdAt', 'Créé le');
        yield DateTimeField::new('updatedAt', 'Mis à jour le');
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var Media $media */
        $media = $entityInstance;

        $media->setName($media->getFilename());

        parent::persistEntity($entityManager, $media);
    }
}
