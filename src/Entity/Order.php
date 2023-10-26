<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Book::class)]
    private Collection $oBook;

    #[ORM\ManyToMany(targetEntity: Book::class)]
    private Collection $linkBook;

    public function __construct()
    {
        $this->oBook = new ArrayCollection();
        $this->linkBook = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, book>
     */
    public function getOBook(): Collection
    {
        return $this->oBook;
    }

    public function addOBook(book $oBook): static
    {
        if (!$this->oBook->contains($oBook)) {
            $this->oBook->add($oBook);
        }

        return $this;
    }

    public function removeOBook(book $oBook): static
    {
        $this->oBook->removeElement($oBook);

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getLinkBook(): Collection
    {
        return $this->linkBook;
    }

    public function addLinkBook(Book $linkBook): static
    {
        if (!$this->linkBook->contains($linkBook)) {
            $this->linkBook->add($linkBook);
        }

        return $this;
    }

    public function removeLinkBook(Book $linkBook): static
    {
        $this->linkBook->removeElement($linkBook);

        return $this;
    }
}
