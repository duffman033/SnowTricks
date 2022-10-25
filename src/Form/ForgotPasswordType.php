<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ForgotPasswordType extends AbstractType
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
                'send',
                SubmitType::class,
                [
                    'label' => "label.send"
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                // Configure your form options here
            ]
        );
    }
}
