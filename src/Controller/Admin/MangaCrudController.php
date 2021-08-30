<?php

namespace App\Controller\Admin;

use App\Entity\Manga;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MangaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Manga::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            ImageField::new('logo', 'Logo')
                ->setBasePath('img/manga/logo/')
                ->setUploadDir('public/img/manga/logo')
                ->setRequired(false),

            ImageField::new('image', 'Image')
                ->setBasePath('img/manga/')
                ->setUploadDir('public/img/manga')
                ->setRequired(false),
            TextField::new('title', 'Nom'),
            TextareaField::new('description', 'Description')->onlyOnForms(),
            SlugField::new('slug')->setTargetFieldName('title')
        ];
    }

}
