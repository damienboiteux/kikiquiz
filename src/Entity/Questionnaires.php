<?php

namespace App\Entity;

use App\Repository\QuestionnairesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionnairesRepository::class)]
class Questionnaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $consigne = null;

    #[ORM\ManyToMany(targetEntity: Questions::class, inversedBy: 'questionnaires')]
    private Collection $questions;

    #[ORM\ManyToMany(targetEntity: Classes::class, inversedBy: 'questionnaires')]
    private Collection $classes;

    #[ORM\OneToMany(mappedBy: 'questionnaires', targetEntity: Examens::class)]
    private Collection $examens;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->classes = new ArrayCollection();
        $this->examens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getConsigne(): ?string
    {
        return $this->consigne;
    }

    public function setConsigne(string $consigne): self
    {
        $this->consigne = $consigne;

        return $this;
    }

    /**
     * @return Collection<int, Questions>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Questions $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    public function removeQuestion(Questions $question): self
    {
        $this->questions->removeElement($question);

        return $this;
    }

    /**
     * @return Collection<int, Classes>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classes $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
        }

        return $this;
    }

    public function removeClass(Classes $class): self
    {
        $this->classes->removeElement($class);

        return $this;
    }

    /**
     * @return Collection<int, Examens>
     */
    public function getExamens(): Collection
    {
        return $this->examens;
    }

    public function addExamen(Examens $examen): self
    {
        if (!$this->examens->contains($examen)) {
            $this->examens->add($examen);
            $examen->setQuestionnaires($this);
        }

        return $this;
    }

    public function removeExamen(Examens $examen): self
    {
        if ($this->examens->removeElement($examen)) {
            // set the owning side to null (unless already changed)
            if ($examen->getQuestionnaires() === $this) {
                $examen->setQuestionnaires(null);
            }
        }

        return $this;
    }
}
