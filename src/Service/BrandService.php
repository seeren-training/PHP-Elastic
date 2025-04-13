<?php

namespace App\Service;

use App\Entity\Brand;
use App\Manager\ORM;

class BrandService
{

    public function __construct(private ORM $orm) {}

    public function createBrand(string $name): Brand
    {
        $entityManager = $this->orm->getEntityManager();

        $brand = new Brand();
        $brand->setName($name);

        $entityManager->persist($brand);
        $entityManager->flush();

        return $brand;
    }
}
