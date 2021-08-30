<?php

namespace App\Controller\Admin;

use App\Entity\Purchase;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class PurchaseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Purchase::class;
    }


     public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('user', 'Client')) ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user','E-mail'),
            TextField::new('fullName', 'Client'),
            TextField::new('billingAddress', 'Adresse'),
            TextField::new('postalCodeBilling', 'Code Postal'),
            TextField::new('city', 'Ville'),
            IntegerField::new('total', 'Total'),
            DateTimeField::new('purchasedAt', 'Date d\'achat'),
        ];
    }

}
