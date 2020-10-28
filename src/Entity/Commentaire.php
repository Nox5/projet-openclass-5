<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *  @Assert\NotBlank(message = "Le nom ne peut être vide")
     *  @Assert\Length(
     *  min = 3,
     *  max = 70,
     *  minMessage = "Ce titre est trop court",
     *  maxMessage = "Ce titre est trop long"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotBlank(message = "Le contenu ne peut être vide")
     * @ORM\Column(type="string", length=255)
     */
    private $contenu;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Chronique::class, inversedBy="commentaire")
     */
    private $chronique;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

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

    public function getChronique(): ?Chronique
    {
        return $this->chronique;
    }

    public function setChronique(?Chronique $chronique): self
    {
        $this->chronique = $chronique;

        return $this;
    }
}
