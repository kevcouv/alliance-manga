<?php

namespace App\Controller\Admin;

use App\Entity\PurchaseItem;
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
            AssociationField::new('purchase','Commande'),
            AssociationField::new('product','Article'),
            TextField::new('productName', 'Titre'),
            IntegerField::new('productPrice', 'Prix'),
            IntegerField::new('quantity', 'Quantité'),
            IntegerField::new('total', 'Total'),

        ];
    }
}
