<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;

#[Route('/users', name: 'users.')]
class UserController extends AbstractController
{
    #[Route('/all', name: 'all_users')]
    public function index(EntityManagerInterface $em): Response
    {
        $userRepo = $em->getRepository(User::class);
        $users = $userRepo->findAll();
        return $this->render('user/all.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier_user')]
    public function update(UserRepository $userRepo , User $user , Request $req): Response
    {
        $form = $this->createForm(UserType::class , $user);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $userRepo->save($user , true);
            return $this->redirect($this->generateUrl('users.all_users'));
        }
        return $this->render('user/modifier.html.twig', [
            'form' => $form ,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer_user')]
    public function delete(EntityManagerInterface $em , User $user): Response
    {
        $userRepo = $em->getRepository(User::class);
        $userRepo->remove($user , true);
        return $this->redirect($this->generateUrl('users.all_users'));
    }
}
