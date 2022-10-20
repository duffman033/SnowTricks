<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => "label.email",
                    'required' => true,
                    'attr' => [
                        'placeholder' => "placeholder.email",
                        'class' => 'form-control'
                    ],

                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => "message.requiredEmail"
                            ]
                        ),
                        new Email(
                            [
                                'message' => "message.invalidEmail"
                            ]
                        )
                    ]

                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => "label.username",
                    'required' => true,
                    'attr' => [
                        'placeholder' => "placeholder.username",
                        'class' => 'form-control'
                    ],
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => "message.requiredField"
                            ]
                        )
                    ]

                ]
            )
            ->add(
                'agreeTerms',
                CheckboxType::class,
                [
                    'label' => "label.terms",
                    'mapped' => false,
                    'constraints' => [
                        new IsTrue(
                            [
                                'message' => 'message.terms',
                            ]
                        ),
                    ],
                ]
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,

                    // Pas de label sur le champ "repeated
                    'label' => false,

                    'required' => true,
                    'mapped' => false,

                    // Option du premier champ
                    'first_options' => [
                        'label' => "label.password",
                        'attr' => [
                            'placeholder' => "placeholder.password",
                            'class' => 'form-control'
                        ],
                        'constraints' => [
                            new NotBlank(
                                [
                                    'message' => "message.newPassRequired",
                                ]
                            ),
                            new Length(
                                [
                                    'min' => 6,
                                    'minMessage' => "message.maxPassword",
                                    'max' => 32,
                                    'maxMessage' => "message.minPassword",
                                ]
                            ),
                        ]
                    ],

                    // Option du second champ
                    'second_options' => [
                        'label' => "label.confirmPassword",
                        'attr' => [
                            'placeholder' => "placeholder.confirmPassword",
                            'class' => 'form-control'
                        ]
                    ],

                    // Message d'erreur
                    'invalid_message' => "message.invalidTwoPasswor",
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
