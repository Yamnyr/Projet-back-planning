<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[ApiResource]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lib_evenement = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $desc_evenement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToMany(targetEntity: Groupe::class, inversedBy: 'evenements')]
    private Collection $concerne;

    #[ORM\ManyToOne(inversedBy: 'evenement')]
    private ?Utilisateur $utilisateur = null;

    public function __construct()
    {
        $this->concerne = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibEvenement(): ?string
    {
        return $this->lib_evenement;
    }

    public function setLibEvenement(string $lib_evenement): self
    {
        $this->lib_evenement = $lib_evenement;

        return $this;
    }

    public function getDescEvenement(): ?string
    {
        return $this->desc_evenement;
    }

    public function setDescEvenement(?string $desc_evenement): self
    {
        $this->desc_evenement = $desc_evenement;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(?\DateTimeInterface $heure_debut): self
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(?\DateTimeInterface $heure_fin): self
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * @return Collection<int, Groupe>
     */
    public function getConcerne(): Collection
    {
        return $this->concerne;
    }

    public function addConcerne(Groupe $concerne): self
    {
        if (!$this->concerne->contains($concerne)) {
            $this->concerne->add($concerne);
        }

        return $this;
    }

    public function removeConcerne(Groupe $concerne): self
    {
        $this->concerne->removeElement($concerne);

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
