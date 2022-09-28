<?php
declare(strict_types=1);

namespace App\Model\Repository;

use App\Entity\Category;
use App\Entity\Product;
use App\Model\Dto\CategoryDataTransferObject;
use App\Model\Dto\ProductDataTransferObject;
use App\Model\Mapper\ProductsMapper;
use Doctrine\ORM\EntityManagerInterface;
use function PHPUnit\Framework\isNull;

class ProductRepository
{
    public function __construct(private EntityManagerInterface $entityManager, private ProductsMapper $prodMapper)
    {
    }

    public function findById(int $id): ProductDataTransferObject|null
    {
        $product = $this->entityManager->getRepository(Product::class)
            ->findOneBy([
                'id' => $id,
                'active' => true
            ]);

        return is_null($product) ? null :
            $this->prodMapper->mapEntityToDto($product);
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

    public function getAll(): array
    {
        $products = $this->entityManager->getRepository(Product::class)->findBy([
            'active' => true
        ]);

        foreach ($products as $key => $product) {
            $products[$key] = $this->prodMapper->mapEntityToDto($product);
        }
        return $products;
    }
}