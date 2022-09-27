<?php
declare(strict_types=1);

namespace App\Controller\Backend;

use App\Model\EntityManager\ProductEntityManager;
use App\Model\Mapper\ProductsMapper;
use App\Model\Repository\CategoryRepository;
use App\Model\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository,
        private ProductEntityManager $productEntityManager,
        private ProductsMapper $productsMapper
    )
    {}

    #[Route('/backend/product/list')]
    public function list(): Response
    {
        $products = $this->productRepository->getAll();
        return $this->render('backend/product/list.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/backend/product/show/{productId}')]
    public function show(int $productId): Response
    {
        $product = $this->productRepository->findById($productId);
        return $this->render('backend/product/show.html.twig', [
            'title' => $product->name,
            'product' => $product,
        ]);
    }

    #[Route('/backend/product/add')]
    public function add(): Response
    {
        return $this->render('backend/product/add.html.twig', [
            'title' => 'Product creation',
            'categories' => $this->categoryRepository->getAll()
        ]);
    }

    #[Route('/backend/product/create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $product = ['id' => 0, 'active' => true];
        $product['name'] = $request->request->get('name');
        $product['size'] = $request->request->get('size');
        $product['color'] = $request->request->get('color');
        $product['category'] = $request->request->get('category');
        $product['stock'] = $request->request->get('stock');
        $product['price'] = $request->request->get('price');

        $product['category'] = $this->categoryRepository->findById((int)$product['category']);

        $id = $this->productEntityManager->addProduct(
            $this->productsMapper->mapToDto($product)
        );
        $product = $this->productRepository->findById($id);

        return $this->render('backend/product/create.html.twig', [
            'title' => $product->name,
            'product' => $product
        ]);
    }
}