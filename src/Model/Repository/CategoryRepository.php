<?php
declare(strict_types=1);

namespace App\Model\Repository;

use App\Entity\Category;
use App\Model\Dto\CategoryDataTransferObject;
use App\Model\Mapper\CategoriesMapper;
use Doctrine\ORM\EntityManagerInterface;

class CategoryRepository
{
    public function __construct(private EntityManagerInterface $entityManager, private CategoriesMapper $catMapper)
    {
    }

    public function findById(int $id): CategoryDataTransferObject|null
    {
        $category = $this->entityManager->getRepository(Category::class)
            ->findOneBy([
                'id' => $id,
                'active' => true
            ]);

        return is_null($category) ? null :
            $this->catMapper->mapEntityToDto($category);
    }

    public function getAll(): array
    {
        $categories = $this->entityManager->getRepository(Category::class)
            ->findBy(['active' => true]);

        foreach ($categories as $key => $category) {
            $categories[$key] = $this->catMapper->mapEntityToDto($category);
        }
        return $categories;
    }
}