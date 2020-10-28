<?php

namespace App\Entity;

use App\Repository\BandeDessineeRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BandeDessineeRepository::class)
 */
class BandeDessinee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * 
     * @Assert\NotBlank(message = "Le titre ne peut être vide.")
     * @Assert\Length(
     *  min = 4,
     *  max = 70,
     *  minMessage = "Ce titre est trop court",
     *  maxMessage = "Ce titre est trop long"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @Assert\NotBlank(message = "Le contenu ne peut être vide.")
     * @ORM\ManyToMany(targetEntity=Auteur::class, mappedBy="bandeDessinees")
     */
    private $auteurs;

    /**
     * 
     * @Assert\NotBlank(message = "Le contenu ne peut être vide.")
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * 
     * @Assert\NotBlank(message = "Une image est nécessaire.")
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=WishList::class, mappedBy="bandeDessinee")
     */
    private $wishLists;

    public function __construct()
    {
        $this->auteurs = new ArrayCollection();
        $this->wishLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection|Auteur[]
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): self
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs[] = $auteur;
            $auteur->addBandeDessinee($this);
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): self
    {
        if ($this->auteurs->contains($auteur)) {
            $this->auteurs->removeElement($auteur);
            $auteur->removeBandeDessinee($this);
        }

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|WishList[]
     */
    public function getWishLists(): Collection
    {
        return $this->wishLists;
    }

    public function addWishList(WishList $wishList): self
    {
        if (!$this->wishLists->contains($wishList)) {
            $this->wishLists[] = $wishList;
            $wishList->addBandeDessinee($this);
        }

        return $this;
    }

    public function removeWishList(WishList $wishList): self
    {
        if ($this->wishLists->contains($wishList)) {
            $this->wishLists->removeElement($wishList);
            $wishList->removeBandeDessinee($this);
        }

        return $this;
    }
}
