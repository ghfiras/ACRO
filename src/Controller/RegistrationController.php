<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRole('user');
            $user->setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('app_lessons'));
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/{id}/change-password', name:"app_password")]
    public function changePassword(Request $req  , UserPasswordHasherInterface $passwordHasher , UserRepository $userRepo , int $id): Response
    {
        $user = $userRepo->find($id);
        $form = $this->createFormBuilder()
            ->add('password' , PasswordType::class , [
                'label' => 'mot de pass' ,
                'attr' => [
                    'placeholder' => '********' ,
                    'autofocus' => true , 
                    'name' => 'old_password'
                ],
                'constraints' => [
                    new NotBlank(), new Length(['min' => 8 ,  'minMessage' => 'minimum 8 characters'])
                ],
            ])
            ->add('confirmPassword' , RepeatedType::class , [
                'type' => PasswordType::class,
                'invalid_message' => 'les champs de mot de passe doivent correspondre .',
                'required' => true,
                'first_options' => ['label' => 'nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe'],
                'options' => ['attr' => [
                    'placeholder' => '********',
                    'name' => 'new_password'
                    ]],
                    'constraints' => [
                        new NotBlank(), new Length(['min' => 8])
                    ],
            ])
            ->getForm();
            $form->handleRequest($req);
            if($form->isSubmitted() && $form->isValid()){
                $data = $form->getData();
                $old = $data['password'];
                $new = $data['confirmPassword'];
                $isValid = $passwordHasher->isPasswordValid($user, $old);
                if($isValid == true){
                    $hashedPassword = $passwordHasher->hashPassword($user, $new);
                    $userRepo->upgradePassword($user,$hashedPassword);
                    return $this->redirect($this->generateUrl('app_lessons'));
                }
                /*$form->get('password')->addError(new FormError('Password incorrect!'));
                $form->get('confirmPassword')->get('second')->addError(new FormError('Passwords do not match!'));*/
                return $this->render('login/modifier-mdp.html.twig' , [
                    'form' => $form->createView() ,
                    'user' => $user ,
                ]);
            }
        return $this->render('login/modifier-mdp.html.twig' , [
            'form' => $form->createView() ,
            'user' => $user,

        ]);
    }

    
}
