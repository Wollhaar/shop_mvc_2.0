<?php
declare(strict_types=1);

namespace AppTest\Repository;

use App\Model\Repository\CategoryRepository;
use App\Model\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductRepositoryTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();

        $this->catRepo = self::getContainer()->get(CategoryRepository::class);
        $this->prodRepo = self::getContainer()->get(ProductRepository::class);
    }

    public function testFindProductsByCategory()
    {
        $category = $this->catRepo->findById(2);
        $products = $this->prodRepo->findProductsByCategory($category);

        self::assertSame(2, $category->id);
        self::assertSame('Pullover', $category->name);

        self::assertCount(1, $products);
        self::assertSame('Hoodie - Kapuzenpulli', $products[0]->name);
    }

    public function testProductFindById()
    {
        $product = $this->prodRepo->findById(3);

        self::assertSame('Hoodie - Kapuzenpulli', $product->name);
        self::assertSame('L,XL', $product->size);
        self::assertSame('braun,grau', $product->color);

        self::assertIsObject($product->category);
        self::assertSame('Pullover', $product->category->name);

        self::assertSame(30.0, $product->price);
        self::assertSame(30, $product->stock);
        self::assertTrue($product->active);
    }
}