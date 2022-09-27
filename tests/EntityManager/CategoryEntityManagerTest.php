<?php
declare(strict_types=1);

namespace AppTest\EntityManger;

use App\Model\EntityManager\CategoryEntityManager;
use App\Model\Mapper\CategoriesMapper;
use App\Model\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryEntityManagerTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->categoryEM = self::getContainer()->get(CategoryEntityManager::class);
        $this->categoryRepo = self::getContainer()->get(CategoryRepository::class);
        $this->categoryMapper = self::getContainer()->get(CategoriesMapper::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $connection = $this->entityManager->getConnection();

        $connection->executeUpdate('UPDATE category SET `active` = 1 WHERE id = 5;');
        $connection->executeUpdate('DELETE FROM category WHERE id > 5;');
        $connection->executeUpdate('ALTER TABLE category AUTO_INCREMENT=10;');
    }

    public function testAddCategory()
    {
        $category = $this->categoryMapper->mapToDto(['id' => 0, 'name' => 'TEST-Category_' . date('h_i_S'), 'active' => true]);
        $id = $this->categoryEM->addCategory($category);
        $category = $this->categoryRepo->findById($id);

        self::assertSame('TEST-Category_' . date('h_i_S'), $category->name);
    }

    public function testDelete()
    {
        $this->categoryEM->delete(5);
        $categories = $this->categoryRepo->getAll();

        self::assertCount(4, $categories);
        self::assertSame('T-Shirt', $categories[0]->name);
        self::assertSame('Pullover', $categories[1]->name);
        self::assertSame('Hosen', $categories[2]->name);
        self::assertSame('Sportswear', $categories[3]->name);
//        self::assertSame('Jacken', $categories[4]->name);
    }
}