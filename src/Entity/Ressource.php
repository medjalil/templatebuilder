<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RessourceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=RessourceRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"read:ressource"}},
 *      collectionOperations={"GET","POST"={"validation_groups"={"read:ressource"}}},
 *      itemOperations={"GET","DELETE","PUT"},
 *      attributes={"pagination_enabled"=false}
 * )
 * @ApiFilter(SearchFilter::class, properties={"mustache": "exact"})
 */
class Ressource {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read:ressource"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:ressource"})
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:ressource"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read:ressource"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Mustache::class, inversedBy="ressources")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:ressource"})
     */
    private $mustache;

    public function getId(): ?int {
        return $this->id;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function setType(string $type): self {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string {
        return $this->content;
    }

    public function setContent(string $content): self {
        $this->content = $content;

        return $this;
    }

    public function getMustache(): ?Mustache {
        return $this->mustache;
    }

    public function setMustache(?Mustache $mustache): self {
        $this->mustache = $mustache;

        return $this;
    }

}
