<?php

namespace App\Entity;

use App\Repository\SynchroRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SynchroRepository::class)]
class Synchro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Joueur::class, inversedBy: 'synchros')]
    #[ORM\JoinColumn(nullable: false)]
    private $joueur1;

    #[ORM\ManyToOne(targetEntity: Joueur::class, inversedBy: 'synchros2')]
    #[ORM\JoinColumn(nullable: false)]
    private $joueur2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJoueur1(): ?Joueur
    {
        return $this->joueur1;
    }

    public function setJoueur1(?Joueur $joueur1): self
    {
        $this->joueur1 = $joueur1;

        return $this;
    }

    public function getJoueur2(): ?Joueur
    {
        return $this->joueur2;
    }

    public function setJoueur2(?Joueur $joueur2): self
    {
        $this->joueur2 = $joueur2;

        return $this;
    }
}
