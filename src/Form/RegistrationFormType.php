<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom' , TextType::class , [
                'attr' =>  [
                    'placeholder' => 'tapez votre prénom ici'             
                ] ,
                'required' => false ,
                'constraints' => [new Length(['min' => 5 , 'minMessage' => '5 charachters minimum']) , new NotBlank(['message' => 'prenom required '])]
            ])
            ->add('nom' , TextType::class , [
                'attr' => [
                    'placeholder' => 'tapez votre nom ici'
                ],
                'required' => false ,
                'constraints' => [new Length(['min' => 5 , 'minMessage' => '5 charachters minimum']) , new NotBlank(['message' => 'nom required '])]
            ])
            ->add('email' , EmailType::class , [
                'attr' => ['placeholder' => 'example@gmail.com'] ,
                'required' => false , 
                'constraints' => [  new NotBlank(['message' => 'email required '])]
            ])
            ->add('password', PasswordType::class, [
                /*'mapped' => false,
                'required' => false ,*/ 
                'attr' => ['autocomplete' => 'new-password',
                            'placeholder' => '********' ,
                    ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => '8 charachters minimum',
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
