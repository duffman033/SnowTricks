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

class TricksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                "label"=>"Nom du trick",
                'attr'=>[
                    'placeholder'=>"Nom du trick",
                    'class' => 'form-control',
                ],
                'required'=>true,
            ])
            ->add('description',TextareaType::class,[
                "label"=>"Desctiprion du trick",
                'attr'=>[
                    'placeholder'=>"Desctiprion du trick",
                    'class' => 'form-control',
                ],
                'required'=>true,
            ])
            ->add('category',ChoiceType::class,[
                'label'=>"Indiquez la catégorie du trick ",'choices'=>[
                    'Les grabs' => 'Les grabs',
                    'Les rotations' => 'Les rotations',
                    'Les flips' => 'Les flips',
                    'Les rotations désaxées' => 'Les rotations désaxées',
                    'Les slides' => 'Les slides',
                    'Les one foot tricks' => 'Les one foot tricks',
                    'Old school' => 'Old school'
                ],
                'attr'=>[
                    'class' => 'form-control',
                ],
                'required'=>true,
            ])
            ->add('pictures', FileType::class,[
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => true,
                'attr'=>[
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
