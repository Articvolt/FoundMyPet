<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('espece', ChoiceType::class, [
                'choices' => [
                    'chat' => 'chat',
                    'chien' => 'chien',
                ],
                'required' => false,
                'label' => 'Espece',
            ])
            ->add('sexeAnimal', ChoiceType::class, [
                'choices' => [
                    'Mâle' => 'Mâle',
                    'Femelle' => 'Femelle',
                ],
                'required' => false,
                'label' => 'sexe',
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'perdu' => 'perdu',
                    'trouvé' => 'trouvé',
                ],
                'required' => false,
                'label' => 'Statut',
            ])
            ->add('puce', ChoiceType::class, [
                'choices' => [
                    'oui' => 'oui',
                    'non' => 'non',
                    'ne sais pas' => 'ne sais pas',
                ],
                'required' => false,
                'label' => 'pucé ?',
            ])

            ->add('tatoue', ChoiceType::class, [
                'choices' => [
                    'oui' => 'oui',
                    'non' => 'non',
                    'ne sais pas' => 'ne sais pas',
                ],
                'required' => false,
                'label' => 'tatoué ?',
            ])
            ->add('ville', TextType::class, [
                'required' => false,
                'label' => 'Ville',
            ])
            ->add('nomAnimal', TextType::class, [
                'required' => false,
                'label' => "nom de l'animal",
            ])
            ->add('rechercher', SubmitType::class, [
                'row_attr' => ['class' => 'filterBtn']
            ])
            ->add('reset', ResetType::class, [
                'label' => 'Réinitialiser',
                'row_attr' => ['class' => 'filterBtn']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
