<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Repository\CategoriesRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
#[UniqueEntity(fields: ['label'], message: "La catégorie {{ value }} existe déjà")]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 3,
        max: 32,
        minMessage: 'Le nom de la catégorie doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Le nom de la catégorie doit comporter au plus {{ limit }} caractères',
    )]
    #[Assert\NotBlank(message: "Le nom de la catégorie ne peut pas être vide")]
    private ?string $label = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
