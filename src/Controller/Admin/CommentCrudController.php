<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }



    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('user'))
            ->add(EntityFilter::new('product'))
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            BooleanField::new('isPublished', 'Publication'),
            AssociationField::new('user', 'Utilisateur')->hideOnForm(),
            TextareaField::new('message', 'Commentaire'),
            AssociationField::new('product', 'Article'),
            IntegerField::new('rating', 'Evaluation'),
            DateTimeField::new('createdAt','Date de création')->hideOnForm()
        ];
    }

}
