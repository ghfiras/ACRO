<?php

namespace App\Controller;

use App\Entity\Choix;
use App\Entity\Question;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/question', name: 'question')]
class QuestionController extends AbstractController
{
    #[Route('/all', name: '_all')]
    public function all(EntityManagerInterface $em ): Response
    {
        $repo = $em->getRepository(Question::class);
        $questions = $repo->findAll();
        return $this->render('question/all.html.twig', [
            'questions' => $questions,
        ]);
    }

    #[Route('/add', name: 'app_question_add')]
    public function add(EntityManagerInterface $em  , Request $req ): Response
    {
        $question = new Question();
        $QuestionForm = $this->createForm(QuestionType::class , $question);
        $QuestionForm->handleRequest($req);
        $choix1 = new Choix();
        $choix1->setChoix("أتوقف");
        $choix1->setCorrect(true);
        $choix2 = new Choix();
        $choix2->setChoix("أحافظ على نفس السرعة و أمر");
        $choix2->setCorrect(false);
        $choix3 = new Choix();
        $choix3->setChoix("أزيد في السرعة");
        $choix3->setCorrect(false);
        if($QuestionForm->isSubmitted() && $QuestionForm->isValid())
        {
            $em->persist($question);
            $em->flush();
            $choix1->setQuestion($question);
            $choix2->setQuestion($question);
            $choix3->setQuestion($question);
            $em->persist($choix1);
            $em->persist($choix2);
            $em->persist($choix3);
            $em->flush();
            return $this->redirect($this->generateUrl('question_all'));
        }

        return $this->render('question/add.html.twig', [
            'QuestionForm' => $QuestionForm ,
        ]);
    }
}
