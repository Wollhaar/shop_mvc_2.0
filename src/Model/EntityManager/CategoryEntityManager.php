<?php
declare(strict_types=1);

namespace App\Model\EntityManager;

use App\Entity\Category;
use App\Model\Dto\CategoryDataTransferObject;
use App\Model\Mapper\CategoriesMapper;
use Doctrine\ORM\EntityManagerInterface;

class CategoryEntityManager
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function addCategory(CategoryDataTransferObject $categoryDTO): int
    {
        $category = new Category();
        $category->name = $categoryDTO->name;
        $category->active = $categoryDTO->active;

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category->id;
    }

    public function delete(int $id): void
    {
        $category = $this->entityManager->find(Category::class, $id);
        $category->active = false;

        $this->entityManager->flush();
    }
}