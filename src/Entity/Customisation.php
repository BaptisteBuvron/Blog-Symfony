<?php

namespace App\Entity;

use App\Repository\CustomisationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=CustomisationRepository::class)
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class Customisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $littleDescription;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $insta;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $presentationArticle;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $imageName;

    /**
     * @var File
     * @Vich\UploadableField(mapping="custom_image", fileNameProperty="imageName")
     * @Assert\File(maxSize="15M", mimeTypes={"image/jpeg","image/jpg","image/png","image/webp"} )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLittleDescription(): ?string
    {
        return $this->littleDescription;
    }

    public function setLittleDescription(string $littleDescription): self
    {
        $this->littleDescription = $littleDescription;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getInsta(): ?string
    {
        return $this->insta;
    }

    public function setInsta(?string $insta): self
    {
        $this->insta = $insta;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getPresentationArticle(): ?Article
    {
        return $this->presentationArticle;
    }

    public function setPresentationArticle(?Article $presentationArticle): self
    {
        $this->presentationArticle = $presentationArticle;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersistSetDatePublished()
    {

        if ($this->updatedAt == null) {
            $this->updatedAt = new \DateTimeImmutable('now');
        }
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdateSetUpdatedDate()
    {
        $this->updatedAt = new \DateTimeImmutable('now');
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile(File $imageFile): void
    {
        $this->imageFile = $imageFile;
        //Si aucun autre champ n'est modfifier, l'image ne s'upload pas
        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTimeImmutable('now');
        }
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }




}
