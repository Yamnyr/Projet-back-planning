<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Get;
use App\Controller\EvenementController;
use App\Controller\GroupeController;
use App\Controller\UtilisateurGroupe;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GroupeRepository::class)]
#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/user/{id_user}/group/{id_group}',
            uriVariables: [
                'id_user' => new Link(toProperty: 'utilisateurs', fromClass: Utilisateur::class),
                'id_group' => new Link(fromClass: Groupe::class),
            ],
            controller: UtilisateurGroupe::class,
            openapiContext: [
                'summary' => 'add a user to a group',
                'description' => 'add a user to a group',
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
                        'description' => 'User added to group',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'message' => [
                                            'type' => 'string',
                                            'example' => 'Succes : Utilisateur ajouté',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    '404' => [
                        'description' => 'User or group not found',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'message' => [
                                            'type' => 'string',
                                            'example' => 'error : Utilisateur inexistant',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ),
        New Get(
            uriTemplate: '/groupe/me',
            controller: GroupeController::class,
            normalizationContext: ['groups' => ['getgroupe:read']],
        ),
        new Delete(
            uriTemplate: '/user/{id_user}/group/{id_group}',
            uriVariables: [
                'id_user' => new Link(toProperty: 'utilisateurs', fromClass: Utilisateur::class),
                'id_group' => new Link(fromClass: Groupe::class),
            ],
            controller: UtilisateurGroupe::class,
            openapiContext: [
                'summary' => 'remove a user from a group',
                'description' => 'remove a user from a group',
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
        new Put(
            uriTemplate: '/group/{this_id_groupe}/group/{in_id_groupe}',
            uriVariables: [
                'this_id_groupe' => new Link(fromClass: Groupe::class),
                'in_id_groupe' => new Link(fromClass: Groupe::class),
            ],
            controller: UtilisateurGroupe::class,
            openapiContext: [
                'summary' => 'add a group to a group',
                'description' => 'add a group to a group',
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
                        'description' => 'Group added to group',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'message' => [
                                            'type' => 'string',
                                            'example' => 'Succes : Groupe ajouté',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    '404' => [
                        'description' => 'Group not found',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'message' => [
                                            'type' => 'string',
                                            'example' => 'error : Groupe inexistant',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ),
    ],
)]
#[ApiResource(
    normalizationContext: ['groups' => ['groupe:read']]
)]
#[ApiFilter(OrderFilter::class, properties: ['lib_groupe', 'desc_groupe', 'color'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['lib_groupe' => 'partial', 'desc_groupe' => 'partial', 'color' => 'partial'])]
class Groupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    #[Groups(['evenement:read', 'groupe:read', 'utilisateur:read', 'getgroupe:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['evenement:read', 'groupe:read', 'utilisateur:read', 'getgroupe:read'])]
    private ?string $lib_groupe = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['evenement:read', 'groupe:read', 'utilisateur:read', 'getgroupe:read'])]
    private ?string $desc_groupe = null;

    #[ORM\ManyToMany(targetEntity: Evenement::class, mappedBy: 'concerne')]
    private Collection $evenements;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: 'creer_groupe')]
    #[Groups(['groupe:read'])]
    private Collection $utilisateurs;

    #[ORM\Column(length: 7)]
    #[Groups(['evenement:read', 'groupe:read', 'utilisateur:read', 'getgroupe:read'])]
    private ?string $color = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'groupes', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([ 'utilisateur:read', 'getgroupe:read', 'groupe:read'])]
    private ?self $groupe_parent = null;

    #[ORM\OneToMany(mappedBy: 'groupe_parent', targetEntity: self::class)]
    #[Groups(['groupe:read'])]
    private Collection $groupes;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->groupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibGroupe(): ?string
    {
        return $this->lib_groupe;
    }

    public function setLibGroupe(string $lib_groupe): self
    {
        $this->lib_groupe = $lib_groupe;

        return $this;
    }

    public function getDescGroupe(): ?string
    {
        return $this->desc_groupe;
    }

    public function setDescGroupe(?string $desc_groupe): self
    {
        $this->desc_groupe = $desc_groupe;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->addConcerne($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            $evenement->removeConcerne($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->addCreerGroupe($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            $utilisateur->removeCreerGroupe($this);
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getGroupeParent(): ?self
    {
        return $this->groupe_parent;
    }

    public function setGroupeParent(?self $groupe_parent): self
    {
        $this->groupe_parent = $groupe_parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(self $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes->add($groupe);
            $groupe->setGroupeParent($this);
        }

        return $this;
    }

    public function removeGroupe(self $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getGroupeParent() === $this) {
                $groupe->setGroupeParent(null);
            }
        }

        return $this;
    }
}
