<?php
declare(strict_types=1);

namespace AppTest\EntityManger;

use App\Model\EntityManager\ProductEntityManager;
use App\Model\Mapper\ProductsMapper;
use App\Model\Repository\CategoryRepository;
use App\Model\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductEntityManagerTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->categoryRepository = self::getContainer()->get(CategoryRepository::class);
        $this->productRepository = self::getContainer()->get(ProductRepository::class);
        $this->productEntityManager = self::getContainer()->get(ProductEntityManager::class);
        $this->productMapper = self::getContainer()->get(ProductsMapper::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $connection = $this->entityManager->getConnection();

        $connection->executeUpdate('DELETE FROM product WHERE id > 8;');
        $connection->executeUpdate('ALTER TABLE product AUTO_INCREMENT=10;');
    }

    public function testAddProduct()
    {
        $product = [
            'id' => 0,
            'name' => 'TestProdukt_EM_' . date('h_i'),
            'size' => 'L',
            'color' => 'black',
            'category' => '3',
            'price' => '22.89',
            'stock' => '202',
            'active' => true,
        ];

        $product['category'] = $this->categoryRepository->findById((int)$product['category']);
        $id = $this->productEntityManager->addProduct(
            $this->productMapper->mapToDto($product)
        );
        $product = $this->productRepository->findById($id);


        self::assertSame('TestProdukt_EM_' . date('h_i'), $product->name);
        self::assertSame('L', $product->size);
        self::assertSame('black', $product->color);
        self::assertSame('Hosen', $product->category->name);
        self::assertSame(22.89, $product->price);
        self::assertSame(202, $product->stock);
        self::assertTrue($product->active);
    }
}