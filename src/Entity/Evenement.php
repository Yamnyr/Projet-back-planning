<?php

namespace App\Entity;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactory;
use ApiPlatform\Core\OpenApi\Model\Parameter;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\PathResolver\CustomOperationPathResolver;
use ApiPlatform\Doctrine\Odm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\CollectionOperationInterface;
use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link;
use ApiPlatform\OpenApi\Model\Parameter as ModelParameter;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\EvenementController;
use Doctrine\ORM\Query\Parameter as QueryParameter;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['evenement:read']],
)]
#[ApiResource(
    operations:[
        new Get(
            uriTemplate: '/evenements/start/{date_start}/end/{date_end}',
            uriVariables: [
                'date_start' => new Link(fromClass: evenement::class),
                'date_end' => new Link(fromClass: evenement::class),
                // 'lib_groupe' => new Parameter(name: 'lib_groupe', in: 'query', schema: ['type' => 'string']),
            ],
            controller: EvenementController::class,
            openapiContext:[
                'parameters' => [
                    [
                        'name' => 'lib_groupe',
                        'in' => 'query',
                        'required' => false,
                        'schema' => [
                            'type' => 'string',
                        ],
                    ],
                ]
                ],
        )
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['concerne.lib_groupe' => 'partial', 'date'=> 'partial', 'id' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['date'])]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['evenement:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['evenement:read', 'groupe:read', 'utilisateur:read'])]
    private ?string $lib_evenement = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['evenement:read', 'groupe:read', 'utilisateur:read'])]
    private ?string $desc_evenement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['evenement:read', 'groupe:read', 'utilisateur:read'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToMany(targetEntity: Groupe::class, inversedBy: 'evenements')]
    #[Groups(['evenement:read'])]
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
