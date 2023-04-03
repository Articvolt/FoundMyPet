<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Model\RechercheData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'rechercher via un mot clé'
                ],
                'empty_data' => '',
                'required' => false
            ])

            ->add('annonces', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Annonce::class,
                'expanded' => true,
                'multiple' => true
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // pas besoin d'identification
            'csrf_protection' => false,
            // methode de récupération d'information (pas de création)
            'method' => 'GET',
            // la classe a qui il va faire référence
            'data_class' => RechercheData::class,
        ]);
    }
}
