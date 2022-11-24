<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ApiResource]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_utilisateur = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom_utilisateur = null;

    #[ORM\ManyToMany(targetEntity: Groupe::class, inversedBy: 'utilisateurs')]
    private Collection $creer_groupe;

    #[ORM\ManyToMany(targetEntity: Matiere::class, inversedBy: 'utilisateurs')]
    private Collection $Avoir_matiere;

    public function __construct()
    {
        $this->creer_groupe = new ArrayCollection();
        $this->Avoir_matiere = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nom_utilisateur;
    }

    public function setNomUtilisateur(string $nom_utilisateur): self
    {
        $this->nom_utilisateur = $nom_utilisateur;

        return $this;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenom_utilisateur;
    }

    public function setPrenomUtilisateur(string $prenom_utilisateur): self
    {
        $this->prenom_utilisateur = $prenom_utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Groupe>
     */
    public function getCreerGroupe(): Collection
    {
        return $this->creer_groupe;
    }

    public function addCreerGroupe(Groupe $creerGroupe): self
    {
        if (!$this->creer_groupe->contains($creerGroupe)) {
            $this->creer_groupe->add($creerGroupe);
        }

        return $this;
    }

    public function removeCreerGroupe(Groupe $creerGroupe): self
    {
        $this->creer_groupe->removeElement($creerGroupe);

        return $this;
    }

    /**
     * @return Collection<int, Matiere>
     */
    public function getAvoirMatiere(): Collection
    {
        return $this->Avoir_matiere;
    }

    public function addAvoirMatiere(Matiere $avoirMatiere): self
    {
        if (!$this->Avoir_matiere->contains($avoirMatiere)) {
            $this->Avoir_matiere->add($avoirMatiere);
        }

        return $this;
    }

    public function removeAvoirMatiere(Matiere $avoirMatiere): self
    {
        $this->Avoir_matiere->removeElement($avoirMatiere);

        return $this;
    }
}
