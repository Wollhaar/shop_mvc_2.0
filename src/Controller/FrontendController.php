<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Repository\CategoryRepository;
use App\Model\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class FrontendController extends AbstractController
{
    public function __construct(private Environment $twig, private CategoryRepository $catRepo, private ProductRepository $prodRepo)
    {
    }

    #[Route('/')]
    public function home(): Response
    {
        $categories = $this->catRepo->getAll();

        return $this->render('frontend/home.html.twig', [
            'title' => 'Home',
            'categories' => $categories
        ]);
    }

    #[Route('/categories/{categoryId}')]
    public function categories(int $categoryId = null): Response
    {
        $categories = $this->catRepo->getAll();
        if ($categoryId) {
            $category = $this->catRepo->findById($categoryId);
            $products = $this->prodRepo->findProductsByCategory($category);
        }

        return $this->render('frontend/categories.html.twig', [
            'title' => 'Kategorien',
            'categories' => $categories,
            'category' => $category ?? null,
            'products' => $products ?? null
        ]);
    }

    #[Route('/detail/{productId}')]
    public function detailed(int $productId = null): Response
    {
        if ($productId) {
            $product = $this->prodRepo->findById($productId);
        }

        $retrun = $this->twig->render('frontend/detailed.html.twig', [
            'title' => isset($product) ? $product->name : '404 - Product not found',
            'product' => $product ?? null
        ]);

        return new Response($retrun);
    }
}