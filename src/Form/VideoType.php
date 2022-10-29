<?php

namespace App\Form;

use App\Entity\Tricks;
use App\Entity\Video;
use App\Repository\TricksRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Contracts\Translation\TranslatorInterface;

class VideoType extends AbstractType
{
    public $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                    'constraints' => [
                        new Regex(
                            [
                                'pattern' => "^((http(s)?:\\/\\/)?((w){3}.)?youtu(be|.be)?(\\.com)?\\/.+)|(/http:\/\/www\.dailymotion\.com\/video\/+/)|((http(s)?:\\/\\/)?((w){3}.)?dai(ly|.ly)?(\\.com)?\\/.+)|((http(s)?:\/\/)?((w){3}.)?player.vimeo.com/video\/.+)|(#TO_DELETE#)^",
                                'message' => $this->translator->trans('message.video')
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
                'data_class' => Video::class,
                'tricks' => null
            ]
        );
    }
}