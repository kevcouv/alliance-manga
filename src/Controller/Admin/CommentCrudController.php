<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
            ->add(EntityFilter::new('user', 'Utilisateur'))
            ->add(EntityFilter::new('product', 'Article'))
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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commentaire')
            ->setEntityLabelInPlural('Commentaires')

            ->setSearchFields(['title'])
            ->setDefaultSort([ 'createdAt' => 'DESC'])
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
