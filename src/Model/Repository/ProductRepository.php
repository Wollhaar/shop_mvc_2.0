<?php
declare(strict_types=1);

namespace App\Model\Repository;

use App\Entity\Category;
use App\Entity\Product;
use App\Model\Dto\CategoryDataTransferObject;
use App\Model\Dto\ProductDataTransferObject;
use App\Model\Mapper\ProductsMapper;
use Doctrine\ORM\EntityManagerInterface;

class ProductRepository
{
    public function __construct(private EntityManagerInterface $entityManager, private ProductsMapper $prodMapper)
    {
    }

    public function findById(int $id): ProductDataTransferObject
    {
        return $this->prodMapper->mapEntityToDto(
            $this->entityManager->find(Product::class, $id)
        );
    }

    public function findProductsByCategory(CategoryDataTransferObject $category): array
    {
        $products = $this->entityManager->getRepository(Product::class)
                ->findBy([
                    'category' => $category->id,
                    'active' => true
        ]);

        foreach ($products as $key => $product) {
            $products[$key] = $this->prodMapper->mapEntityToDto($product);
        }

        return $products;
    }
}