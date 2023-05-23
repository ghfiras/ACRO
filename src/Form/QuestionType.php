<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
            ]  )
            ->add('image')
            ->add('categorie' , EntityType::class , [
                'class' => Categorie::class ,
                'choice_label' => 'categorie' ,
                'mapped' => true,
            ])
            ->add('choix1' , TextType::class, [
                'label' => 'choix 1:'  ,
                'mapped' => false
            ])
            ->add('choix2' , TextType::class, [
                'label' => 'choix 2:'  ,
                'mapped' => false
            ])
            ->add('choix3' , TextType::class, [
                'label' => 'choix 3:'  ,
                'mapped' => false
            ])
            ->add('isCorrect' , ChoiceType::class , [
                'mapped' => false ,
                'choices' =>[
                    'choix 1' => 'choix1' ,
                    'choix 2' => 'choix2' ,
                    'choix 3' => 'choix3',
                ] ,
                'label' => 'Choix Correct ?'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'isCorrect' => null,
        ]);
    }
}
