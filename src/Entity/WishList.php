<?php

namespace App\Entity;

use App\Repository\WishListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WishListRepository::class)
 */
class WishList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=BandeDessinee::class, inversedBy="wishLists")
     */
    private $bandeDessinee;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="wishLists")
     */
    private $user;

    public function __construct()
    {
        $this->bandeDessinee = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|BandeDessinee[]
     */
    public function getBandeDessinee(): Collection
    {
        return $this->bandeDessinee;
    }

    public function addBandeDessinee(BandeDessinee $bandeDessinee): self
    {
        if (!$this->bandeDessinee->contains($bandeDessinee)) {
            $this->bandeDessinee[] = $bandeDessinee;
        }

        return $this;
    }

    public function removeBandeDessinee(BandeDessinee $bandeDessinee): self
    {
        if ($this->bandeDessinee->contains($bandeDessinee)) {
            $this->bandeDessinee->removeElement($bandeDessinee);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
