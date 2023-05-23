<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Service\userService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LessonsController extends AbstractController
{
    #[Route('/lessons', name: 'app_lessons')]
    public function index(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Categorie::class);
        $lessons = $repo->findAll();
        return $this->render('lessons/all.html.twig', [
            'lessons' =>  $lessons ,
            'user' => $this->getUser(),
        ]);
    }

    
}
