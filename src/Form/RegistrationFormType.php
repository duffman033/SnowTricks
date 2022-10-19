<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Votre adresse email",
                'required' => true,
                'attr' => [
                    'placeholder' => "Saisir votre email",
                    'class' => 'form-control'
                ],

                'constraints' => [
                    new NotBlank([
                        'message' => "L'adresse email est obligatoire"
                    ]),
                    new Email([
                        'message' => "L'adresse email n'est pas valide"
                    ])
                ]

            ])
            ->add('name', TextType::class, [
                'label' => "Votre nom",
                'required' => true,
                'attr' => [
                    'placeholder' => "Ecrivez votre nom",
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "Ce champ est obligatoire"
                    ])
                ]

            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "j'accepte les termes et conditions",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,

                // Pas de label sur le champ "repeated
                'label' => false,

                'required' => true,
                'mapped' => false,

                // Option du premier champ
                'first_options' => [
                    'label' => "Mot de passe",
                    'attr' => [
                        'placeholder' => "Saisir votre mot de passe",
                        'class' => 'form-control'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => "Nouveau mot de passe requis",
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => "Minimum de 6 caractères",
                            'max' => 32,
                            'maxMessage' => "Maximum de 32 caractères",
                        ]),
                    ]
                ],

                // Option du second champ
                'second_options' => [
                    'label' => "Confirmation du mot de passe",
                    'attr' => [
                        'placeholder' => "Répétez votre mot de passe",
                        'class' => 'form-control'
                    ]
                ],

                // Message d'erreur
                'invalid_message' => "Les champs ne sont pas identiques",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
