<?php

namespace App\Service;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Color;
use App\Entity\Product;
use App\Manager\ORM;

class ProductService
{

    public function __construct(
        private ORM $orm,
        private ProductSearchService $productSearchService,
    ) {
    }

    public function getProducts(
        int $page,
        ?string $search,
        ?array $filters,
        int $limit = 12
    ): array {
        $offset = ($page - 1) * $limit;

        [$count, $ids, $filters] = $this->productSearchService->searchIds(
            $offset,
            $limit,
            $search
        );
        $products = $this->orm
            ->getEntityManager()
            ->getRepository(Product::class)
            ->findBy(['id' => $ids]);

        $positionMap = array_flip($ids);

        usort(
            $products,
            fn($a, $b) => $positionMap[$a->getId()] <=> $positionMap[$b->getId()]
        );

        return [$count, $limit, $offset, $products, $filters];
    }

    public function getProduct(int $id): Product
    {
        return $this->orm
            ->getEntityManager()
            ->getRepository(Product::class)
            ->findOneById($id);
    }

    public function createProduct(
        string $name,
        string $description,
        string $imageLink,
        float $price,
        string $brand,
        string $category,
        array $colors,
    ): Product {
        $entityManager = $this->orm->getEntityManager();

        $product = (new Product())
            ->setName($name)
            ->setDescription($description)
            ->setImageLink($imageLink)
            ->setPrice($price)
            ->setBrand($entityManager
                ->getRepository(Brand::class)
                ->findOneByName($brand))
            ->setCategory($entityManager
                ->getRepository(Category::class)
                ->findOneByName($category));

        foreach ($colors as $hexa) {
            $product->addColor($entityManager
                ->getRepository(Color::class)
                ->findOneByHex($hexa));
        }

        $entityManager->persist($product);
        $entityManager->flush();

        $this->productSearchService->indexProduct($product);

        return $product;
    }
}
