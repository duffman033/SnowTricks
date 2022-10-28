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
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationFormType extends AbstractType
{

    public $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void
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
                                'message' => $this->translator->trans("message.requiredEmail")
                            ]
                        ),
                        new Email(
                            [
                                'message' => $this->translator->trans("message.invalidEmail")
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
                                'message' => $this->translator->trans("message.requiredField")
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
                                'message' => $this->translator->trans('message.terms'),
                            ]
                        ),
                    ],
                ]
            )
            ->add(
                'avatar',
                FileType::class,
                [
                    'required' => false,
                    'label' => "label.avatar",
                    'mapped' => false,
                    'multiple' => false,
                    'attr' => [
                        'class' => 'form-control',
                        'accept' => 'image/*'
                    ],
                    'constraints' => [
                        new File(
                            [
                                'maxSize' => '1024k',
                                'mimeTypes' => [
                                    'image/*',
                                ],
                                'mimeTypesMessage' => $this->translator->trans('message.mimeType'),
                            ]
                        )
                    ]
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
                                    'message' => $this->translator->trans("message.newPassRequired"),
                                ]
                            ),
                            new Length(
                                [
                                    'min' => 6,
                                    'minMessage' => $this->translator->trans("message.maxPassword"),
                                    'max' => 32,
                                    'maxMessage' => $this->translator->trans("message.minPassword"),
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
                    'invalid_message' => $this->translator->trans("message.invalidTwoPassword"),
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
