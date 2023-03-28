<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // informations du propriétaire

            ->add('nomProprietaire', TextType::class,[
                'label' => 'Nom '
                ])
            ->add('prenomProprietaire', TextType::class,[
                'label' => 'Prénom'
                ])


    // moyen de contacter le propriétaire

            ->add('adresseMail', EmailType::class,[
                'label' => 'Adresse mail'
                ])
            ->add('telephone', TelType::class,[
                'label' => 'Numéro de téléphone'
                ])


    // lieu où l'animal a été perdu

            ->add('adresse', TextType::class,[
                'label' => 'Adresse'
                ])
            ->add('codePostal', TextType::class,[
                'label' => 'Code postal'
                ])
            ->add('ville', TextType::class,[
                'label' => 'Ville'
                ])


    // informations de l'animal

            ->add('category', ChoiceType::class, [
                'label' => 'Perdu ou Trouvé ?',
                'choices' => [
                    'perdu' => 'perdu' ,
                    'trouvé' => 'trouvé',
                ],
            ])

            ->add('nomAnimal', TextType::class,[
                'label' => "Nom de l'animal"
                ])

            ->add('espece', ChoiceType::class, [
                'label' => 'Espèce',
                'choices' => [
                    'chien' => 'chien' ,
                    'chat' => 'chat',
                ],
                'data' => 'chat',
            ])

            ->add('image', FileType::class, [
                'label' => false,
                // n'est pas lié à la base de données
                'mapped' => false,
                'required' => false,
                // 'constraints' => [
                //         'maxSize' => '1024k',
                //         'mimeTypes' => [
                //             'image/jpeg',
                //             'image/jpg',
                //             'image/png',
                //         ],
                //     ]
            ])
        
            
    // description d'identification
            
            ->add('ageAnimal', IntegerType::class, [
                'label' => "âge de l'animal",
                'attr' => ['min' => 0, 'max' => 30],
                'required' => true,
                // 'help' => "Veuillez entrer l'âge de l'animal en âge humain",
                'data' => '1'
            ])
       
            ->add('sexeAnimal', ChoiceType::class, [
                'label' => 'Sexe',
                'choices' => [
                    'Mâle' => 'Mâle' ,
                    'Femelle' => 'Femelle',
                ],
                'data' => 'Mâle',
            ])

            ->add('puce', ChoiceType::class, [
                'label' => 'pucé ?',
                'choices' => [
                    'ne sais pas' => 'ne sais pas' ,
                    'oui' => 'oui' ,
                    'non' => 'non',
                ],
                'data' => 'ne sais pas',
                'required' => true,
            ])

            ->add('tatoue', ChoiceType::class, [
                'label' => 'tatoué ?',
                'choices' => [
                    'ne sais pas' => 'ne sais pas' ,
                    'oui' => 'oui' ,
                    'non' => 'non',
                ],
                'data' => 'ne sais pas',
                'required' => true,
            ])

            
    // description pelage de l'animal

            ->add('taillePoil', ChoiceType::class, [
                'label' => 'Taille du pelage',
                'choices' => [
                    'sans poil' => 'sans poil' ,
                    'court' => 'court',
                    'mi-long' => 'mi-long',
                    'long' => 'long',
                ],
                'required' => true,
                'data' => 'court',
            ])

            ->add('couleurPoil', ChoiceType::class, [
                'label' => 'couleur du pelage',
                'choices' => [
                    'roux' => 'roux' ,
                    'noir' => 'noir',
                    'beige' => 'beige',
                    'blanc' => 'blanc',
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => true,
            ])

            ->add('dessinPoil', ChoiceType::class, [
                'label' => 'dessin du pelage',
                'choices' => [
                    'uni' => 'uni',
                    'tigré' => 'tigré' ,
                    'tacheté' => 'tacheté',
                ],
            ])


    // description complémentaire

            ->add('description', TextareaType::class,[
                'label' => 'informations complémentaires',
                'attr' => [
                    'placeholder' => 'Saisissez votre message ici'
                ]
                ])
        
            // validation du formulaire
            ->add('submit', SubmitType::class, [
                'label' => 'valider'
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
