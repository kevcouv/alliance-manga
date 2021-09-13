<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
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
            ->add(EntityFilter::new('manga', 'Manga'))
            ->add(EntityFilter::new('category', 'Catégorie'))
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            BooleanField::new('isPublished', 'Publication'),
            ImageField::new('image', 'Image')
                ->setBasePath('img/product/')
                ->setUploadDir('public/img/product')
                ->setRequired(false),
            TextField::new('title', 'Titre'),
            TextField::new('nameCharacter','Personnage'),
            AssociationField::new('manga','Manga'),
            AssociationField::new('category','Catégorie'),
            TextareaField::new('smallDescription', 'Petite description')->onlyOnForms(),
            TextareaField::new('fullDescription','Grosse description')->onlyOnForms(),
            TextField::new('price', 'Prix'),
            DateTimeField::new('createdAt', 'Date de création')->hideOnForm(),
            SlugField::new('slug')->setTargetFieldName('title')

        ];
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits')

            ->setSearchFields(['title', 'nameCharacter'])
            ->setDefaultSort(['created_at' => 'DESC'])
            ;
    }

    public function configureActions(Actions$actions): Actions
    {
        return $actions
            // ...
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Modifier');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Modifier et ajouter un nouveau produit');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Modifier et retourner');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Modifier et retourner');
            })
            ;
    }




}
