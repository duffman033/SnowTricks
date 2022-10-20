<?php

namespace App\Form;

use App\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class TricksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    "label" => "label.trickName",
                    'attr' => [
                        'placeholder' => "label.trickName",
                        'class' => 'form-control',
                    ],
                    'required' => true,
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    "label" => "label.trickDescription",
                    'attr' => [
                        'placeholder' => "label.trickDescription",
                        'class' => 'form-control',
                    ],
                    'required' => true,
                ]
            )
            ->add(
                'category',
                ChoiceType::class,
                [
                    'label' => "label.trickCategory",
                    'choices' => [
                        'Les grabs' => 'label.grabs',
                        'Les rotations' => 'label.rotations',
                        'Les flips' => 'label.flips',
                        'Les rotations désaxées' => 'label.rotationsOffaxis',
                        'Les slides' => 'label.slides',
                        'Les one foot tricks' => 'label.oneFootTrick',
                        'Old school' => 'label.oldSchool'
                    ],
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'required' => true,
                ]
            )
            ->add(
                'pictures',
                FileType::class,
                [
                    'label' => false,
                    'multiple' => true,
                    'mapped' => false,
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ]
            )
            ->add(
                'url',
                TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'label.videoLink'
                    ],
                    'required' => false,
                    'mapped' => false,
                    'constraints' => [
                        new Regex(
                            [
                                'pattern' => "^
                                ((http(s)?:\\/\\/)?((w){3}.)?youtu(be|.be)?(\\.com)?\\/.+)|
                                (/http:\/\/www\.dailymotion\.com\/video\/+/)|
                                ((http(s)?:\\/\\/)?((w){3}.)?dai(ly|.ly)?(\\.com)?\\/.+)|
                                ((http(s)?:\/\/)?((w){3}.)?player.vimeo.com/video\/.+)|(#TO_DELETE#)
                                ^",
                                'message' => 'message.video'
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
                'data_class' => Tricks::class,
                'csrf_protection' => false,
            ]
        );
    }
}
