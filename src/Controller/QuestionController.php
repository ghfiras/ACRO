<?php

namespace App\Controller;

use App\Entity\Choix;
use App\Entity\Question;
use App\Entity\Categorie;
use App\Form\QuestionType;
use App\Repository\CategorieRepository;
use App\Repository\ChoixRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Traits\RedisProxy;
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
            'user' => $this->getUser()
        ]);
    }

    #[Route('/add', name: 'app_question_add')]
    public function add(Request $req ,  EntityManagerInterface $em): Response
    {
        
        $quest = new Question();
        $form = $this->createForm(QuestionType::class , $quest);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $choix1_text = $form->get('choix1')->getData();
            $choix2_text = $form->get('choix2')->getData();
            $choix3_text = $form->get('choix3')->getData();
            $correct = $form->get('isCorrect')->getData();
            $choix1 = new Choix();
            $choix2 = new Choix();
            $choix3 = new Choix();
            $choix1->setChoix($choix1_text);
            $choix2->setChoix($choix2_text);
            $choix3->setChoix($choix3_text);
            if($correct == 'choix1'){
                $choix1->setCorrect(true);
                $choix2->setCorrect(false);
                $choix3->setCorrect(false);
            }else if($correct == 'choix2'){
                $choix1->setCorrect(false);
                $choix2->setCorrect(true);
                $choix3->setCorrect(false);
            }else if($correct == 'choix3'){
                $choix1->setCorrect(false);
                $choix2->setCorrect(false);
                $choix3->setCorrect(true);
            }
            $choix1->setQuestion($quest);
            $choix2->setQuestion($quest);
            $choix3->setQuestion($quest);
            $em->persist($choix1);
            $em->persist($choix2);
            $em->persist($choix3);
            $em->persist($quest);
            $em->flush();
            return $this->redirect($this->generateUrl('question_all'));
        }
        return $this->render('question/add.html.twig' , [
            'form' => $form ,
        ]);
    }
    #[Route('/modifier/{id}', name: '_modifier')]
    public function update(QuestionRepository $questRepo , int $id, Request $req  ,EntityManagerInterface $em): Response
    {
        $question = $questRepo->find($id);
        $choix1 = $question->getChoixes()->get(0);
        $choix2 =  $question->getChoixes()->get(1);
        $choix3 =  $question->getChoixes()->get(2);
        if ($choix1->isCorrect()){
            $choixValue = 'choix1';
        }else if($choix2->isCorrect()){
            $choixValue = 'choix2';
        }else{
            $choixValue = 'choix3';
        }
        $form = $this->createForm(QuestionType::class , $question , [
            'isCorrect' => $choixValue ,
        ]);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $choix1_text = $form->get('choix1')->getData();
            $choix2_text = $form->get('choix2')->getData();
            $choix3_text = $form->get('choix3')->getData();
            $correct = $form->get('isCorrect')->getData();
            $choix1->setChoix($choix1_text);
            $choix2->setChoix($choix2_text);
            $choix3->setChoix($choix3_text);
            if($correct == 'choix1'){
                $choix1->setCorrect(true);
                $choix2->setCorrect(false);
                $choix3->setCorrect(false);
            }else if($correct == 'choix2'){
                $choix1->setCorrect(false);
                $choix2->setCorrect(true);
                $choix3->setCorrect(false);
            }else if($correct == 'choix3'){
                $choix1->setCorrect(false);
                $choix2->setCorrect(false);
                $choix3->setCorrect(true);
            }
            $em->flush();
            return $this->redirect($this->generateUrl('question_all'));
        }
        return $this->render('question/update.html.twig', [
            'form' => $form ,
            'isCorrect' => $form->getConfig()->getOption('isCorrect'), 
            'choix1' => $choix1->getChoix() ,
            'choix2' => $choix2->getChoix() ,
            'choix3' => $choix3->getChoix() ,
        ]);
    }
    #[Route('supprimer/{id}/', name: '_supprimer')]
    public function delete(EntityManagerInterface $em  , QuestionRepository $questRepo , Question $question): Response
    {
        $questRepo->remove($question , true);
        return $this->redirect($this->generateUrl('question_all'));
    }


}
