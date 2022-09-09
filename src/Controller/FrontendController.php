<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Repository\CategoryRepository;
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
    public function categories(?int $categoryId, CategoryRepository $catRepo): Response
    {
//        $categories = $catRepo->getAll();
        if ($categoryId) {
            $category = $catRepo->findById($categoryId);
        }

        return $this->render('frontend/categories.html.twig', [
            'title' => 'Shop',
            'categories' => $categories,
            'category' => $category ?? null
        ]);
    }
}