<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\MustacheRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MustacheRepository::class)
 * @ApiResource()
 */
class Mustache {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read:ressource"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $function;

    /**
     * @ORM\ManyToOne(targetEntity=Environment::class, inversedBy="mustaches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $environment;

    /**
     * @ORM\OneToMany(targetEntity=Ressource::class, mappedBy="mustache", orphanRemoval=true,cascade={"persist"})
     */
    private $ressources;

    /**
     * @ORM\OneToMany(targetEntity=Attachment::class, mappedBy="mustache", orphanRemoval=true)
     */
    private $attachments;

    public function __construct() {
        $this->ressources = new ArrayCollection();
        $this->attachments = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getFunction(): ?string {
        return $this->function;
    }

    public function setFunction(string $function): self {
        $this->function = $function;

        return $this;
    }

    public function getEnvironment(): ?Environment {
        return $this->environment;
    }

    public function setEnvironment(?Environment $environment): self {
        $this->environment = $environment;

        return $this;
    }

    /**
     * @return Collection|Ressource[]
     */
    public function getRessources(): Collection {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): self {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources[] = $ressource;
            $ressource->setMustache($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): self {
        if ($this->ressources->contains($ressource)) {
            $this->ressources->removeElement($ressource);
            // set the owning side to null (unless already changed)
            if ($ressource->getMustache() === $this) {
                $ressource->setMustache(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->getId();
    }

    /**
     * @return Collection|Attachment[]
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $attachment): self
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments[] = $attachment;
            $attachment->setMustache($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): self
    {
        if ($this->attachments->contains($attachment)) {
            $this->attachments->removeElement($attachment);
            // set the owning side to null (unless already changed)
            if ($attachment->getMustache() === $this) {
                $attachment->setMustache(null);
            }
        }

        return $this;
    }

}
