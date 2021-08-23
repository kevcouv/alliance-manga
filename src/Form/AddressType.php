<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('society', TextType::class, ['label' => 'Société'])
            ->add('vat', TextType::class, ['label' => 'Numéro de TVA'])
            ->add('address', TextType::class, ['label' => 'Adresse'] )
            ->add('subAddress', TextType::class, ['label' => 'Complément d\'adresse'])
            ->add('postalCode', TextType::class, ['label' => 'Code Postal'])
            ->add('country', CountryType::class, ['label' => 'Pays'])
            ->add('phoneNumber', TextType::class, ['label' => 'Téléphone'])
            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-info ',
                ),

                'label' => 'Enregistrer'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
