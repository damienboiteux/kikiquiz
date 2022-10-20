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

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?Eleves $eleves = null;


    public function __construct()
    {
        $this->reponsesEleves = new ArrayCollection();
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

    public function getEleves(): ?Eleves
    {
        return $this->eleves;
    }

    public function setEleves(?Eleves $eleves): self
    {
        $this->eleves = $eleves;

        return $this;
    }
}
