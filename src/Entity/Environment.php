<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\EnvironmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EnvironmentRepository::class)
 * @ApiResource()
 *
 */
class Environment {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Mustache::class, mappedBy="environment", orphanRemoval=true)
     */
    private $mustaches;

    public function __construct() {
        $this->mustaches = new ArrayCollection();
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

    /**
     * @return Collection|Mustache[]
     */
    public function getMustaches(): Collection {
        return $this->mustaches;
    }

    public function addMustach(Mustache $mustach): self {
        if (!$this->mustaches->contains($mustach)) {
            $this->mustaches[] = $mustach;
            $mustach->setEnvironment($this);
        }

        return $this;
    }

    public function removeMustach(Mustache $mustach): self {
        if ($this->mustaches->contains($mustach)) {
            $this->mustaches->removeElement($mustach);
            // set the owning side to null (unless already changed)
            if ($mustach->getEnvironment() === $this) {
                $mustach->setEnvironment(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->getName();
    }

}
