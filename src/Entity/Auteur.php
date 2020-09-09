<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuteurRepository::class)
 */
class Auteur
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\ManyToMany(targetEntity=BandeDessinee::class, inversedBy="auteurs")
     */
    private $bandeDessinees;

    public function __construct()
    {
        $this->bandeDessinees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection|BandeDessinee[]
     */
    public function getBandeDessinees(): Collection
    {
        return $this->bandeDessinees;
    }

    public function addBandeDessinee(BandeDessinee $bandeDessinee): self
    {
        if (!$this->bandeDessinees->contains($bandeDessinee)) {
            $this->bandeDessinees[] = $bandeDessinee;
        }

        return $this;
    }

    public function removeBandeDessinee(BandeDessinee $bandeDessinee): self
    {
        if ($this->bandeDessinees->contains($bandeDessinee)) {
            $this->bandeDessinees->removeElement($bandeDessinee);
        }

        return $this;
    }
}
