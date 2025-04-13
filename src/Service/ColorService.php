<?php

namespace App\Service;

use App\Entity\Color;
use App\Manager\ORM;

class ColorService
{

    public function __construct(private ORM $orm) {}

    public function createColor(
        string $name,
        string $hex
    ): Color {
        $entityManager = $this->orm->getEntityManager();

        $color = (new Color())
            ->setName($name)
            ->setHex(strtoupper($hex));

        $entityManager->persist($color);
        $entityManager->flush();

        return $color;
    }
}
