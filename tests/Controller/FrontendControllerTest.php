<?php
declare(strict_types=1);

namespace AppTest\Controller;

use App\Controller\FrontendController;
use App\Model\Repository\CategoryRepository;
use App\Model\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Twig\Environment;

class FrontendControllerTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();

        $this->catRepo = self::getContainer()->get(CategoryRepository::class);
        $this->prodRepo = self::getContainer()->get(ProductRepository::class);
//        $this->controller = self::getContainer()->get(FrontendController::class);
//        $this->twig = self::getContainer()->get(Environment::class);
    }

    public function testHome()
    {
//        $this->controller->home();
//        $categories = $this->twig->();
        $categories = $this->catRepo->getAll();

        self::assertCount(5, $categories);
        self::assertSame('T-Shirt', $categories[0]->name);
        self::assertSame('Pullover', $categories[1]->name);
        self::assertSame('Hosen', $categories[2]->name);
        self::assertSame('Sportswear', $categories[3]->name);
        self::assertSame('Jacken', $categories[4]->name);
    }

    public function testCategories()
    {
        $categories = $this->catRepo->getAll();
        $category = $this->catRepo->findById(2);
        $products = $this->prodRepo->findProductsByCategory($category);

        self::assertCount(5, $categories);
        self::assertSame(2, $category->id);
        self::assertSame('Pullover', $category->name);

        self::assertCount(1, $products);
        self::assertSame('Hoodie - Kapuzenpulli', $products[0]->name);
    }

    public function testDetailed()
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