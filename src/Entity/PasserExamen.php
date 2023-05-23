<?php

namespace App\Entity;

use App\Repository\PasserExamenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Reponse;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PasserExamenRepository::class)]
class PasserExamen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'passerExamens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Examen $examen = null;

    #[ORM\ManyToOne(inversedBy: 'passerExamens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'passerExamen', targetEntity: Reponse::class)]
    private Collection $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExamen(): ?Examen
    {
        return $this->examen;
    }

    public function setExamen(?Examen $examen): self
    {
        $this->examen = $examen;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->setPasserExamen($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getPasserExamen() === $this) {
                $reponse->setPasserExamen(null);
            }
        }

        return $this;
    }
    public function getScore():int{
        $reponses = $this->getReponses();
        $score = 0 ;
        foreach($reponses as $res){
            if($res->getChoix() != null && $res->getChoix()->isCorrect()){
                $score = $score +1 ;
            }
        }

        return $score;
    }
    /*public function fixExamen():void{
        $responsesLen = count($this->getReponses());
        $questions = $this->getExamen()->getQuestions();
        if($responsesLen != 30){
            for($i = $responsesLen ; $i < 30 ; $i++){
                $res = new Reponse();
                $res->setQuestion($questions->get($i));
                $res->setChoix(null);
                $res->setPasserExamen($this);
            }
        }

    }*/
}
