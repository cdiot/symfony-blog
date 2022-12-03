<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Repository\OptionRepository;
use EasyCorp\Bundle\EasyAdminBundle\Collection\EntityCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class OptionCrudController extends AbstractCrudController
{
    public function __construct(
        private OptionRepository $optionRepository
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Option::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::BATCH_DELETE)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_ADMIN')
            ->setSearchFields(null)
            ->setEntityLabelInPlural('Réglages généraux')
            ->showEntityActionsInlined();
    }

    public function index(AdminContext $context): KeyValueStore|Response
    {
        $response = parent::index($context);

        if ($response instanceof Response) {
            return $response;
        }

        /** @var EntityCollection $entities */
        $entities = $response->get('entities');

        foreach ($entities as $entity) {
            $fields = $entity->getFields();

            $valueField = $fields->getByProperty('value');

            $fields->unset($valueField);
        }

        $response->set('entities', $entities);

        return $response;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('label', 'Option')
            ->setFormTypeOption('attr', [
                'readonly' => true
            ])
            ->setSortable(false);

        yield TextField::new('value');
    }
}
