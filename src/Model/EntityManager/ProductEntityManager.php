<?php
declare(strict_types=1);

namespace App\Model\EntityManager;

use App\Entity\Category;
use App\Entity\Product;
use App\Model\Dto\ProductDataTransferObject;
use Doctrine\ORM\EntityManagerInterface;

class ProductEntityManager
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {}

    public function addProduct(ProductDataTransferObject $product): int
    {
        $productEntity = new Product();
        $productEntity->name = $product->name;
        $productEntity->size = $product->size;
        $productEntity->color = $product->color;
        $productEntity->price = $product->price;
        $productEntity->stock = $product->stock;
        $productEntity->active = $product->active;

        $category = $this->entityManager->find(Category::class, $product->category->id);
        $productEntity->setCategory($category);

        $this->entityManager->persist($productEntity);
        $this->entityManager->flush();

        return $productEntity->id;
    }
}