<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AttachmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AttachmentRepository::class)
 * @Vich\Uploadable
 */
class Attachment {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileJoint;

    /**
     * @Vich\UploadableField(mapping="file_attachments", fileNameProperty="fileJoint")
     * @var File
     */
    private $joint;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Mustache::class, inversedBy="attachments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mustache;

    public function __construct() {
        $this->updatedAt = new \DateTime("now");
    }

    public function getId(): ?int {

        return $this->id;
    }

    public function getFileJoint(): ?string {
        return $this->fileJoint;
    }

    public function setFileJoint(string $fileJoint): self {
        $this->fileJoint = $fileJoint;

        return $this;
    }

    public function setJoint(File $fileJoint = null) {
        $this->joint = $fileJoint;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($fileJoint) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getJoint() {
        return $this->joint;
    }

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getMustache(): ?Mustache
    {
        return $this->mustache;
    }

    public function setMustache(?Mustache $mustache): self
    {
        $this->mustache = $mustache;

        return $this;
    }

}
