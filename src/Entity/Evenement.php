<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Controller\EvenementGroupeController;
use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Odm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;


#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[ApiResource]
#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/event/{id_event}/group/{id_group}',
            uriVariables: [
                'id_event' => new Link(toProperty: 'evenements', fromClass: Evenement::class),
                'id_group' => new Link(fromClass: Groupe::class),
            ],
            controller: EvenementGroupeController::class,
            openapiContext: [
                'summary' => 'add a event to a group',
                'description' => 'add a event to a group',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [],
                            ],
                        ],
                    ],
                ],
                'response' => [
                    '201' => [
                        'description' => 'Event added to group',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'message' => [
                                            'type' => 'string',
                                            'example' => 'Succes : Evenement ajouté',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    '404' => [
                        'description' => 'Event or group not found',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'message' => [
                                            'type' => 'string',
                                            'example' => 'error : Evenement inexistant',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ),
        new Delete(
            uriTemplate: '/event/{id_event}/group/{id_group}',
            uriVariables: [
                'id_event' => new Link(toProperty: 'evenements', fromClass: Evenement::class),
                'id_group' => new Link(fromClass: Groupe::class),
            ],
            controller: EvenementGroupeController::class,
            openapiContext: [
                'summary' => 'remove an event from a group',
                'description' => 'remove an event from a group',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [],
                            ],
                        ],
                    ],
                ],
            ]
        ),
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['lib_evenement', 'desc_evenement', 'date'], arguments: ['orderParameterName' => 'order'])]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lib_evenement = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $desc_evenement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heure_debut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heure_fin = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $localisation = null;

    #[ORM\ManyToMany(targetEntity: Groupe::class, inversedBy: 'evenements', cascade: ['persist'])]
    private Collection $concerne;

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
