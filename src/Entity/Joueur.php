<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @UniqueEntity(fields={"pseudo"}, message="Ce pseudo est déja utilisé")
 */
#[ORM\Entity(repositoryClass: JoueurRepository::class)]
class Joueur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $pseudo;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 30)]
    private $nom;

    #[ORM\Column(type: 'string', length: 30)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 50)]
    private $email;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $discord_id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $steam_id;

    #[ORM\Column(type: 'integer')]
    private $tryhard_meter;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'joueurs')]
    private $categorie;

    #[ORM\ManyToMany(targetEntity: Jeu::class, inversedBy: 'joueurs')]
    private $jeu;

    #[ORM\Column(type: 'string', length: 255)]
    private $profil_img;

    #[ORM\OneToMany(mappedBy: 'joueur1', targetEntity: Synchro::class, orphanRemoval: true)]
    private $synchros;

    #[ORM\OneToMany(mappedBy: 'joueur2', targetEntity: Synchro::class, orphanRemoval: true)]
    private $synchros2;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $supprimer;

    public function __construct()
    {
        $this->categorie = new ArrayCollection();
        $this->jeu = new ArrayCollection();
        $this->synchros = new ArrayCollection();
        $this->synchros2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->pseudo;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDiscordId(): ?string
    {
        return $this->discord_id;
    }

    public function setDiscordId(?string $discord_id): self
    {
        $this->discord_id = $discord_id;

        return $this;
    }

    public function getSteamId(): ?string
    {
        return $this->steam_id;
    }

    public function setSteamId(?string $steam_id): self
    {
        $this->steam_id = $steam_id;

        return $this;
    }

    public function getTryhardMeter(): ?int
    {
        return $this->tryhard_meter;
    }

    public function setTryhardMeter(int $tryhard_meter): self
    {
        $this->tryhard_meter = $tryhard_meter;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie[] = $categorie;
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        $this->categorie->removeElement($categorie);

        return $this;
    }

    /**
     * @return Collection|Jeu[]
     */
    public function getJeu(): Collection
    {
        return $this->jeu;
    }

    public function addJeu(Jeu $jeu): self
    {
        if (!$this->jeu->contains($jeu)) {
            $this->jeu[] = $jeu;
        }

        return $this;
    }

    public function removeJeu(Jeu $jeu): self
    {
        $this->jeu->removeElement($jeu);

        return $this;
    }

    public function getProfilImg(): ?string
    {
        return $this->profil_img;
    }

    public function setProfilImg(string $profil_img): self
    {
        $this->profil_img = $profil_img;

        return $this;
    }

    /**
     * @return Collection|Synchro[]
     */
    public function getSynchros(): Collection
    {
        return $this->synchros;
    }

    public function addSynchro(Synchro $synchro): self
    {
        if (!$this->synchros->contains($synchro)) {
            $this->synchros[] = $synchro;
            $synchro->setJoueur1($this);
        }

        return $this;
    }

    public function removeSynchro(Synchro $synchro): self
    {
        if ($this->synchros->removeElement($synchro)) {
            // set the owning side to null (unless already changed)
            if ($synchro->getJoueur1() === $this) {
                $synchro->setJoueur1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Synchro[]
     */
    public function getSynchros2(): Collection
    {
        return $this->synchros2;
    }

    public function addSynchros2(Synchro $synchros2): self
    {
        if (!$this->synchros2->contains($synchros2)) {
            $this->synchros2[] = $synchros2;
            $synchros2->setJoueur2($this);
        }

        return $this;
    }

    public function removeSynchros2(Synchro $synchros2): self
    {
        if ($this->synchros2->removeElement($synchros2)) {
            // set the owning side to null (unless already changed)
            if ($synchros2->getJoueur2() === $this) {
                $synchros2->setJoueur2(null);
            }
        }

        return $this;
    }

    public function getSupprimer(): ?bool
    {
        return $this->supprimer;
    }

    public function setSupprimer(?bool $supprimer): self
    {
        $this->supprimer = $supprimer;

        return $this;
    }
}
