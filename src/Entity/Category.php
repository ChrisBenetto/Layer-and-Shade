<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $create_at;

    /**
     * @ORM\OneToMany(targetEntity=Figurine::class, mappedBy="category")
     */
    private $figurines;

    public function __construct()
    {
        $this->figurines = new ArrayCollection();
    }

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

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    /**
     * @return Collection|Figurine[]
     */
    public function getFigurines(): Collection
    {
        return $this->figurines;
    }

    public function addFigurine(Figurine $figurine): self
    {
        if (!$this->figurines->contains($figurine)) {
            $this->figurines[] = $figurine;
            $figurine->setCategory($this);
        }

        return $this;
    }

    public function removeFigurine(Figurine $figurine): self
    {
        if ($this->figurines->removeElement($figurine)) {
            // set the owning side to null (unless already changed)
            if ($figurine->getCategory() === $this) {
                $figurine->setCategory(null);
            }
        }

        return $this;
    }
}
