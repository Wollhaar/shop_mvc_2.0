<?php
declare(strict_types=1);

namespace AppTest\Repository;

use App\Model\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryRepositoryTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();

        $this->catRepo = self::getContainer()->get(CategoryRepository::class);
    }

    public function testGetAll()
    {
        $categories = $this->catRepo->getAll();

        self::assertCount(5, $categories);
        self::assertSame('T-Shirt', $categories[0]->name);
        self::assertSame('Pullover', $categories[1]->name);
        self::assertSame('Hosen', $categories[2]->name);
        self::assertSame('Sportswear', $categories[3]->name);
        self::assertSame('Jacken', $categories[4]->name);
    }
}