<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['evenement:read']],
    denormalizationContext: ['groups' => ['evenement:write']]
)]
#[ApiFilter(SearchFilter::class, properties: ['concerne.lib_groupe' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['date'], arguments: ['orderParameterName' => 'order'])]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['evenement:read', 'evenement:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['evenement:read', 'evenement:write', 'groupe:read', 'utilisateur:read'])]
    private ?string $lib_evenement = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['evenement:read', 'evenement:write', 'groupe:read', 'utilisateur:read'])]
    private ?string $desc_evenement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['evenement:read', 'evenement:write', 'groupe:read', 'utilisateur:read'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToMany(targetEntity: Groupe::class, inversedBy: 'evenements')]
    #[Groups(['evenement:read', 'evenement:write', 'utilisateur:read'])]
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
