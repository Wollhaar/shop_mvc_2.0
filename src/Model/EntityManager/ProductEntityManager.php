<?php
declare(strict_types=1);

namespace App\Model\EntityManager;

use App\Entity\Category;
use App\Entity\Product;
use App\Model\Dto\ProductDataTransferObject;
use App\Model\Mapper\ProductsMapper;
use Doctrine\ORM\EntityManagerInterface;

class ProductEntityManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ProductsMapper $productsMapper
    )
    {}

    public function addProduct(ProductDataTransferObject $product): ProductDataTransferObject
    {
        $productEntity = new Product();
        $productEntity->name = $product->name;
        $productEntity->size = $product->size;
        $productEntity->color = $product->color;
        $productEntity->price = $product->price;
        $productEntity->stock = $product->stock;
        $productEntity->active = $product->active;

        $category = $this->entityManager->find(Category::class, $product->category->id);
        if (isset($category) && $category->id) {
            $productEntity->setCategory($category);
        }
        $this->entityManager->persist($productEntity);
        $this->entityManager->flush();

        return $this->productsMapper->mapEntityToDto($productEntity);
    }

    public function saveProduct(ProductDataTransferObject $productDTO): ProductDataTransferObject|null
    {
        $product = $this->entityManager->getRepository(Product::class)
            ->findOneBy([
                'id' => $productDTO->id,
                'active' => true
            ]);

        if ($product !== null) {
            $product->size = $productDTO->size;
            $product->color = $productDTO->color;
            $product->price = $productDTO->price;
            $product->stock = $productDTO->stock;

            $category = $this->entityManager->find(Category::class, $product->category->id);
            if (isset($category) && $category->id) {
                $product->setCategory($category);
            }

            $this->entityManager->persist($product);
            $this->entityManager->flush();
        }

        return is_null($product) ? null :
            $this->productsMapper->mapEntityToDto($product);
    }

    public function deleteProduct(int $id): void
    {
        $product = $this->entityManager->find(Product::class, $id);

        if (isset($product)) {
            $product->active = false;
            $this->entityManager->flush();
        }
    }
}