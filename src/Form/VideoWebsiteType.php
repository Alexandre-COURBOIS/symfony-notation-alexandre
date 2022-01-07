<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoWebsiteType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, $this->getConfig("Nom de la vidéo", 'Le nom de la vidéo'))
            ->add('Synopsis', TextType::class, $this->getConfig("Synopsis de la vidéo", 'Un résumé succin de la vidéo'))
            ->add('Type', ChoiceType::class, [
                    'choices' => [
                        "Serie" => 'Serie',
                        "Film" => 'Film'
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
