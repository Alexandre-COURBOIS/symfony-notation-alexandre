<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterUserType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, $this->getConfig('Email', 'Votre email'))
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'options' => ['attr' => ['class' => 'password']],
                'required' => true,
                'first_options' => ['label' => "Mot de passe",'attr' => ['placeholder' => 'Votre mot de passe']],
                'second_options' =>['label' => 'Confirmez votre mot de passe', 'attr' => ['placeholder' => 'Confirmez votre mot de passe']]
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
