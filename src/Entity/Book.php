<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'book')]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: order::class)]
    private Collection $oBook;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFileName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getImageFileName(): ?string
    {
        return $this->imageFileName;
    }

    public function setImageFileName(?string $imageFileName): static
    {
        $this->imageFileName = $imageFileName;

        return $this;
    }

    /**
     * @return Collection<int, order>
     */
    public function getOBook(): Collection
    {
        return $this->oBook;
    }

    public function addOBook(order $oBook): static
    {
        if (!$this->oBook->contains($oBook)) {
            $this->oBook->add($oBook);
        }

        return $this;
    }

    public function removeOBook(order $oBook): static
    {
        $this->oBook->removeElement($oBook);

        return $this;
    }
}
