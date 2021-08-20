<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,  [
                'label' => 'Prénom']
            )
            ->add('lastName', TextType::class,  ['label' => 'Nom'])
            ->add('userName', TextType::class, ['label' => 'Pseudo'])
            ->add('email', EmailType::class, ['label' => 'E-mail'])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
