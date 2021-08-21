<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class AddressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Address::class;
    }


    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('country', 'Pays'));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('society', 'Société'),
            AssociationField::new('user', 'Client')->hideOnForm(),
            TextField::new('address', 'Adresse'),
            TextField::new('subAddress', 'Complément d\'adresse'),
            TextField::new('postalCode', 'Code Postal'),
            CountryField::new('country', 'Pays'),
            TextField::new('vat', 'Numéro de TVA'),
            TextField::new('phoneNumber', 'Numéro de Téléphone'),
        ];
    }
}
