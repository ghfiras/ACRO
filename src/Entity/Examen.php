<?php

namespace App\Entity;

use App\Repository\ExamenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

#[ORM\Entity(repositoryClass: ExamenRepository::class)]
class Examen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToMany(targetEntity: Question::class, inversedBy: 'examens')]
    private Collection $questions;

    #[ORM\OneToMany(mappedBy: 'examen', targetEntity: PasserExamen::class)]
    private Collection $passerExamens;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->passerExamens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /*public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }*/
    public function getDate():string{
        return $this->date->format('d-m-Y');;

    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        $this->questions->removeElement($question);

        return $this;
    }

    /**
     * @return Collection<int, PasserExamen>
     */
    public function getPasserExamens(): Collection
    {
        return $this->passerExamens;
    }

    public function addPasserExamen(PasserExamen $passerExamen): self
    {
        if (!$this->passerExamens->contains($passerExamen)) {
            $this->passerExamens->add($passerExamen);
            $passerExamen->setExamen($this);
        }

        return $this;
    }

    public function removePasserExamen(PasserExamen $passerExamen): self
    {
        if ($this->passerExamens->removeElement($passerExamen)) {
            // set the owning side to null (unless already changed)
            if ($passerExamen->getExamen() === $this) {
                $passerExamen->setExamen(null);
            }
        }

        return $this;
    }
}
