<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('user', 'Client'))
            ->add(EntityFilter::new('product', 'Article'))
            ;
    }


    public function configureFields(string $pageName): iterable
    {
         return [
            AssociationField::new('user', 'Client')->hideOnForm(),
            AssociationField::new('product', 'Article'),
            TextField::new('price', 'Total'),
            DateTimeField::new('createdAt','Date de création')->hideOnForm(),
            DateTimeField::new('updatedAt','Date de modification')->hideOnForm()
        ];
    }

}
