<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products')]
class Product implements \JsonSerializable
{
    use HasId;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $imageLink;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'float')]
    private string $price;

    #[ManyToMany(targetEntity: Color::class, inversedBy: 'products')]
    #[JoinTable(name: 'products_colors')]
    private Collection $colors;

    #[ManyToOne(targetEntity: Brand::class)]
    #[JoinColumn(name: 'brand_id', referencedColumnName: 'id')]
    private Brand $brand;

    #[ManyToOne(targetEntity: Category::class)]
    #[JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private Category $category;

    public function __construct()
    {
        $this->colors = new ArrayCollection();
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImageLink(): string
    {
        return $this->imageLink;
    }

    public function setImageLink(string $imageLink): self
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function addColor(Color $color): self
    {
        $this->colors[] = $color;

        return $this;
    }

    public function getColors(): Collection
    {
        return $this->colors;
    }

    public function jsonSerialize(): mixed
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'imageLink' => $this->imageLink,
            'price' => $this->price,
            'brand' => $this->brand->jsonSerialize(),
            'category' => $this->category->jsonSerialize(),
            'colors' => array_map(
                fn(Color $color) => $color->jsonSerialize(),
                [...$this->colors]
            ),
        );
    }
}
