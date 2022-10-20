<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class ResetPasswordType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'plainPassword',
                PasswordType::class,
                [
                    // instead of being set onto the object directly,
                    // this is read and encoded in the controller
                    'mapped' => false,
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
                    ],
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
