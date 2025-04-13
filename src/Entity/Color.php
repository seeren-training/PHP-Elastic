<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

#[ORM\Entity(repositoryClass: ColorRepository::class)]
#[ORM\Table(name: 'colors')]
class Color implements \JsonSerializable
{
    use HasId;

    #[ORM\Column(type: 'string', unique: true)]
    private string $hex;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $name;


    #[ManyToMany(targetEntity: Product::class, mappedBy: 'colors')]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getHex(): string
    {
        return $this->hex;
    }

    public function setHex(string $hex): self
    {
        $this->hex = $hex;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return array(
            'id' => $this->id,
            'hex' => $this->hex,
            'name' => $this->name,
        );
    }
}
