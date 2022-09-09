<?php
declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\Category;
use App\Model\EntityManager\CategoryEntityManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CategoryRepository
{
    public function __construct(private EntityManagerInterface $entityManager, private CategoryEntityManager $categoryEntityManager)
    {
//        $this->entityManager = $entityManager::getManager();
    }

    public function findById(int $id): Category
    {
//        $category = $this->entityManager->find(Category::class, $id);
        $test = $this->categoryEntityManager->addCategory();
        dd($test);
    }

    public function getAll(): array
    {
        return $this->entityManager->getRepository(Category::class)->findAll();
    }
}