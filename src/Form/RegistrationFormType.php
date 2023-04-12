<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Adresse mail",
                'label_attr' => ['class' => 'labelLogin'],
            ])
            ->add('pseudonyme', TextType::class, [
                'label' => "Pseudonyme",
                'label_attr' => ['class' => 'labelLogin'],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "conditions d'utilisation",
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new IsTrue([
                        'message' => "Vous devez accepter les termes d'utilisations",
                    ]),
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes doivent être identiques !',
                'options' => ['attr' => ['class'=>'passwordLogin']],
                'required' => true,
                'first_options' => ['label' => 'Mot de passe',
                    'label_attr' => ['class' => 'labelLogin']],
                    'row_attr' => ['class' => 'passBlocLogin'],
                'second_options' => ['label' => 'Répetez le mot de passe', 
                    'label_attr' => ['class' => 'labelLogin']],
                    'row_attr' => ['class' => 'passBlocLogin'],
                'constraints' => [
                    // règle pour renforcer le mot de passe
                    new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                    "Il faut un mot de passe de 6 caractères avec 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial")
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
