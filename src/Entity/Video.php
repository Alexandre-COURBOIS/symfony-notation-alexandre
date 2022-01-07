<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 *
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     message="Merci de renseigner votre Nom.",
     *     groups={"newVideo"}
     *     )
     *
     * @Assert\NotBlank(
     *     message="Merci de renseigner votre Nom.",
     *     )
     */
    private $Nom;

    /**
     * @ORM\Column(type="text", length=255)
     *
     * @Assert\NotBlank(
     *     message="Merci de renseigner un Synopsis.",
     *     groups={"newVideo"}
     *     )
     *
     * @Assert\NotBlank(
     *     message="Merci de renseigner un Synopsis.",
     *     )
     */
    private $Synopsis;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     message="Merci de renseigner un type série ou film.",
     *     groups={"newVideo"}
     *     )
     *
     * @Assert\NotBlank(
     *     message="Merci de renseigner un type série ou film.",
     *     )
     *
     *
     */
    private $Type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist()
    {
        if (empty($this->getCreatedAt())) {
            $this->setCreatedAt(new \DateTime());
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->Synopsis;
    }

    public function setSynopsis(string $Synopsis): self
    {
        $this->Synopsis = $Synopsis;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
