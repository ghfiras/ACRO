<?php

namespace App\Controller;

use App\Entity\Question;
use App\Service\questionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/examen', name: 'examen.')]
class ExamenController extends AbstractController
{
    #[Route('/', name: 'examen')]
    public function examen( EntityManagerInterface $em , questionService $questSer): Response
    {
        return $this->redirectToRoute('examen.question', ['number' => 0]);
    }
    #[Route('/question/{number}', name: 'question')]
    public function question( int $number  , EntityManagerInterface $em): Response
    {
        $questionRepo = $em->getRepository(Question::class);
        $questions = $questionRepo->findAll();
        $question = $questions[$number];
        return $this->render('examen/question.html.twig', [
            'number' => $number , 
            'question' => $question
        ]);
    }
}
