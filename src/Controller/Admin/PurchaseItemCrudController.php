<?php

namespace App\Controller\Admin;

use App\Entity\PurchaseItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class PurchaseItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PurchaseItem::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('product', 'Article'))
            ->add(EntityFilter::new('purchase', 'Commande')) ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('purchase','Client'),
            AssociationField::new('product','Article'),
            TextField::new('productName', 'Titre'),
            IntegerField::new('productPrice', 'Prix'),
            IntegerField::new('quantity', 'Quantité'),
            IntegerField::new('total', 'Total'),

        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Détails de commande')
            ->setEntityLabelInPlural('Détails des commandes')

            ->setSearchFields(['purchase', 'product', 'productName'])
            ->setDefaultSort(['id' => 'DESC'])
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)

            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Modifier');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action->setLabel('Modifier et continuer');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Modifier et retourner');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('Supprimer');
            })
            ;
    }
}
