<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', TextType::class, ['label' => 'Nom Complet'])
            ->add('subject', TextType::class, ['label' => 'Sujet'] )
            ->add('email', EmailType::class, ['label' => 'Adresse e-mail'])
            ->add('message', TextareaType::class, ['label' => 'Message'])
            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-outline-info'
                ),
                'label' => 'Envoyer'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
