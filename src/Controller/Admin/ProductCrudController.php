<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('manga'));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            BooleanField::new('isPublished'),
            ImageField::new('image', 'Image')
                ->setBasePath('img/product/')
                ->setUploadDir('public/img/product')
                ->setRequired(false),
            TextField::new('title'),
            TextField::new('nameCharacter'),
            AssociationField::new('manga'),
            TextareaField::new('smallDescription')->onlyOnForms(),
            TextareaField::new('fullDescription')->onlyOnForms(),
            TextField::new('price'),
            TextField::new('material')->onlyOnForms(),
            DateTimeField::new('createdAt'),
            DateTimeField::new('updatedAt'),
        ];
    }

}
