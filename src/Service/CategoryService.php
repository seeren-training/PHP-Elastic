<?php

namespace App\Service;

use App\Entity\Category;
use App\Manager\ORM;

class CategoryService
{

    public function __construct(private ORM $orm) {}

    public function createCategory(string $name): Category
    {
        $entityManager = $this->orm->getEntityManager();

        $category = new Category();
        $category->setName($name);

        $entityManager->persist($category);
        $entityManager->flush();

        return $category;
    }
}
