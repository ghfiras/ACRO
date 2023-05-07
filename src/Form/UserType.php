<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom' , TextType::class , [
                'attr' =>  [
                    'placeholder' => 'tapez votre prénom ici'             
                ] 
            ])
            ->add('nom' , TextType::class , [
                'attr' => [
                    'placeholder' => 'tapez votre nom ici'
                ]
            ])
            ->add('email' , EmailType::class , [
                'attr' => [
                    'placeholder' => 'example@gmail.com' ,
                ]
            ])
            ->add('password' , PasswordType::class ,[
                'attr' => [
                    'placeholder' => '********' ,
                ]
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
