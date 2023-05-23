<?php

namespace App\Controller;

use App\Entity\Examen;
use App\Entity\PasserExamen;
use App\Entity\Question;
use App\Entity\Choix;
use App\Entity\Reponse;
use App\Repository\PasserExamenRepository;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/examen', name: 'examen.')]
class ExamenController extends AbstractController
{
    #[Route('/', name: 'examen')]
    public function examen(QuestionRepository $questionRepo , UserRepository $userRepo , EntityManagerInterface $em): Response
    {
        if($this->getUser() == null){
            return $this->redirect($this->generateUrl('app_login'));
        }
        $currentDate = new \DateTime();
        $examen = new Examen();
        $user = $this->getUser() ;
        $questions = $questionRepo->findAll(); 
        for($i=0 ; $i < 30 ; $i++){
            $examen->addQuestion($questions[$i]);
        }
        $examen->setDate($currentDate);
        $em->persist($examen);
        $em->flush();
        $passerExamen = new PasserExamen();
        $passerExamen->setExamen($examen);
        $passerExamen->setUser($user);
        $em->persist($passerExamen);
        $em->flush();
        $passerExamenId = $passerExamen->getId();
        return $this->redirectToRoute('examen.question', ['number' => 0 , 'passerExamenId' => $passerExamenId ]);
    }
    #[Route('/{passerExamenId}/question/{number}', name: 'question')]
    public function question( int $number  , EntityManagerInterface $em , int $passerExamenId): Response
    {
        $questionRepo = $em->getRepository(Question::class);
        $questions = $questionRepo->findAll();
        $question = $questions[$number];
        return $this->render('examen/question.html.twig', [
            'number' => $number , 
            'question' => $question ,
            'passerExamenId' => $passerExamenId ,
            'user' => $this->getUser()
        ]);
    }

    #[Route('/setResponse/{passerExamenId}/{questionId}/{number}', name: 'response')]
    public function setResponse(EntityManagerInterface $em , int $number , int $passerExamenId , int $questionId , Request $req , PasserExamenRepository $passerExamenRepo): Response
    {
        if ($req->isMethod('POST')) {
            $data = $req->request->get('choice');
            if ($data == null){
                $choix = null;
            }else{
                $choixRepo = $em->getRepository(Choix::class);
                $choix = $choixRepo->find($data);
            }
            $reponse = new Reponse();
            $questionRepo = $em->getRepository(Question::class);
            $question = $questionRepo->find($questionId);
            $passer = $passerExamenRepo->find($passerExamenId);
            $reponse->setQuestion($question);
            $reponse->setChoix($choix);
            $reponse->setPasserExamen($passer);
            $em->persist($reponse);
            $em->flush();
            if($number >= 29){
                return $this->redirectToRoute('examen.resultat', ['passerExamenId' => $passerExamenId ]);
            }else{
                return $this->redirectToRoute('examen.question', ['number' => $number+1 , 'passerExamenId' => $passerExamenId ]);
            }
            
        }
    }
    #[Route('/{passerExamenId}/score', name: 'resultat')]
    public function score(PasserExamenRepository $passerExamenRepo , int $passerExamenId): Response
    {
        $passerExamen = $passerExamenRepo->find($passerExamenId);
        return $this->render('examen/resultat.html.twig', [
            'score' => $passerExamen->getScore() , 
            'user' => $this->getUser(),
            'passserExamenId' => $passerExamenId ,
        ]);
    }
    #[Route('/{passerExamenId}/reponse/{number}', name: 'reponse_correct')]
    public function reponse(PasserExamenRepository $passerExamenRepo , int $passerExamenId , int $number): Response
    {
        $passerExamen = $passerExamenRepo->find($passerExamenId);
        return $this->render('examen/reponse.html.twig', [
            'number' => $number , 
            'question' =>  $passerExamen->getReponses()->get($number)->getQuestion() ,
            'choix' => $passerExamen->getReponses()->get($number)->getChoix() ,
            'passerExamen' => $passerExamen ,
            'user' => $this->getUser() ,
        ]);
    }

    
}
