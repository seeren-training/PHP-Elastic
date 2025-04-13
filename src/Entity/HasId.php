<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait HasId
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
