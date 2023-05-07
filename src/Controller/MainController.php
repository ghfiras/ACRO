<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\userService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\GeneratedValue;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function home(): Response
    {
        return $this->render('home/home.html.twig' , [
            'isLOgged' => false ,
            'user' => new User(),
        ]);
    }
    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('home/login.html.twig', []);
    }
    #[Route('/signin', name: 'app_signin')]
    public function signin(Request $req , EntityManagerInterface $em , userService $userSer): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $user->setRole('user');
            $repo = $em->getRepository(User::class);
            $userSer->setUser($user);
            $repo->save($user);
            $em->flush();
            $userSer->setIsLogged(true);
            return $this->redirect($this->generateUrl('app_lessons'));
        }
        return $this->render('home/signin.html.twig' , [
            'form' => $form ,
        ]);
    }
}
