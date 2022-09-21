<?php
declare(strict_types=1);

namespace AppTest\Controller;

use App\Model\Repository\CategoryRepository;
use App\Model\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FrontendControllerTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
        $this->catRepo = self::getContainer()->get(CategoryRepository::class);
        $this->prodRepo = self::getContainer()->get(ProductRepository::class);
    }

    public function testHome()
    {
        $categories = $this->catRepo->getAll();

        self::assertCount(5, $categories);
        self::assertSame('T-Shirt', $categories[0]);
        self::assertSame('Pullover', $categories[1]);
        self::assertSame('Hosen', $categories[2]);
        self::assertSame('Sportswear', $categories[3]);
        self::assertSame('Jacken', $categories[4]);
    }

    public function testCategories()
    {
        $categories = $this->catRepo->getAll();
        $category = $this->catRepo->findById(2);
        $products = $this->prodRepo->findProductsByCategory($category);

        self::assertCount(5, $categories);
        self::assertSame('T-Shirt', $categories[0]->name);
        self::assertSame('Pullover', $categories[1]->name);
        self::assertSame('Hosen', $categories[2]->name);
        self::assertSame('Sportswear', $categories[3]->name);
        self::assertSame('Jacken', $categories[4]->name);

        self::assertSame(2, $category->id);
        self::assertSame('Pullover', $category->name);

        self::assertCount(1, $products);
        self::assertSame('Hoodie - Kapuzenpulli', $products[0]->name);
    }

    public function testDetailed()
    {
        $product = $this->prodRepo->findById(3);

        self::assertSame('Hoodie - Kapuzenpulli', $product->name);
        self::assertSame('M,L', $product->size);
        self::assertSame('grau', $product->color);

        self::assertIsObject($product->category);
        self::assertSame('Pullover', $product->category->name);

        self::assertSame(30.0, $product->price);
        self::assertSame(30, $product->stock);
        self::assertTrue($product->active);
    }
}