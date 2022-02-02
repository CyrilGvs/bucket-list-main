<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Wish::class)]
    private $category_wish;

    public function __construct()
    {
        $this->category_wish = new ArrayCollection();
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

    /**
     * @return Collection|Wish[]
     */
    public function getCategoryWish(): Collection
    {
        return $this->category_wish;
    }

    public function addCategoryWish(Wish $categoryWish): self
    {
        if (!$this->category_wish->contains($categoryWish)) {
            $this->category_wish[] = $categoryWish;
            $categoryWish->setCategories($this);
        }

        return $this;
    }

    public function removeCategoryWish(Wish $categoryWish): self
    {
        if ($this->category_wish->removeElement($categoryWish)) {
            // set the owning side to null (unless already changed)
            if ($categoryWish->getCategories() === $this) {
                $categoryWish->setCategories(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }


}
