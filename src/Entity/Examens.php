<?php

namespace App\Entity;

use App\Repository\ExamensRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExamensRepository::class)]
class Examens
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'examens')]
    private ?Questionnaires $questionnaires = null;

    #[ORM\OneToMany(mappedBy: 'examens', targetEntity: Eleves::class)]
    private Collection $eleves;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionnaires(): ?Questionnaires
    {
        return $this->questionnaires;
    }

    public function setQuestionnaires(?Questionnaires $questionnaires): self
    {
        $this->questionnaires = $questionnaires;

        return $this;
    }

    /**
     * @return Collection<int, Eleves>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addEleve(Eleves $eleve): self
    {
        if (!$this->eleves->contains($eleve)) {
            $this->eleves->add($eleve);
            $eleve->setExamens($this);
        }

        return $this;
    }

    public function removeEleve(Eleves $eleve): self
    {
        if ($this->eleves->removeElement($eleve)) {
            // set the owning side to null (unless already changed)
            if ($eleve->getExamens() === $this) {
                $eleve->setExamens(null);
            }
        }

        return $this;
    }
}
