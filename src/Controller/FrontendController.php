<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Repository\CategoryRepository;
use App\Model\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends AbstractController
{
    #[Route('/')]
    public function home(CategoryRepository $catRepo): Response
    {
        $categories = $catRepo->getAll();

        return $this->render('frontend/home.html.twig', [
            'title' => 'Shop',
            'categories' => $categories
        ]);
    }

    #[Route('/categories/{categoryId}')]
    public function categories(CategoryRepository $catRepo, ProductRepository $prodRepo, int $categoryId = null): Response
    {
        $categories = $catRepo->getAll();
        if ($categoryId) {
            $category = $catRepo->findById($categoryId);
            $products = $prodRepo->findProductsByCategory($category);
        }

        return $this->render('frontend/categories.html.twig', [
            'title' => 'Shop - Kategorien',
            'categories' => $categories,
            'category' => $category ?? null,
            'products' => $products ?? null
        ]);
    }

    #[Route('/detail/{productId}')]
    public function detailed(ProductRepository $prodRepo, CategoryRepository $catRepo, int $productId = null): Response
    {
        if ($productId) {
            $product = $prodRepo->findById($productId);
            $category = $catRepo->findByName($product->category);
        }

        return $this->render('frontend/detailed.html.twig', [
            'title' => isset($product) ? $product->name : '404 - Product not found',
            'category' => $category ?? null,
            'product' => $product ?? null
        ]);
    }
}