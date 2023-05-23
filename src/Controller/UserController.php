<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user', name: 'users.')]
class UserController extends AbstractController
{
    #[Route('/all', name: 'all_users')]
    public function index(EntityManagerInterface $em): Response
    {
        $userRepo = $em->getRepository(User::class);
        $users = $userRepo->findAll();
        return $this->render('user/all.html.twig', [
            'users' => $users ,
            'me' => $this->getUser()
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier_user')]
    public function update(UserRepository $userRepo , User $user , Request $req): Response
    {
        $form = $this->createForm(RegistrationFormType::class , $user);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $selectedRole = $req->request->get('roles');
            $user->setRoles([$selectedRole]);
            $userRepo->save($user , true);
            return $this->redirect($this->generateUrl('users.all_users'));
        }
        return $this->render('user/modifier.html.twig', [
            'form' => $form ,
            'user' => $user ,
            'current' => $this->getUser() ,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer_user')]
    public function delete(EntityManagerInterface $em , User $user): Response
    {
        $userRepo = $em->getRepository(User::class);
        $userRepo->remove($user , true);
        return $this->redirect($this->generateUrl('users.all_users'));
    }
    #[Route('/add', name: 'add_user')]
    public function add(UserRepository $userRepo  , Request $req  , UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class , $user);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $selectedRole = $req->request->get('roles');
            $user->setRoles([$selectedRole]);
            $user->setRole($selectedRole);
            $userRepo->save($user , true);
            return $this->redirect($this->generateUrl('users.all_users'));
        }
        return $this->render('user/add.html.twig', [
            'form' => $form ,
            'current' => $this->getUser() ,
        ]);
    }
}
