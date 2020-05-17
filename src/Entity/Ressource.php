<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RessourceRepository;

/**
 * @ORM\Entity(repositoryClass=RessourceRepository::class)
 */
class Ressource {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Mustache::class, inversedBy="ressources")
     * @ORM\JoinColumn(nullable=false)
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
