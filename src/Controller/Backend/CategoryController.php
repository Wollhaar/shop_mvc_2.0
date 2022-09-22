<?php
declare(strict_types=1);

namespace App\Controller\Backend;

use App\Model\EntityManager\CategoryEntityManager;
use App\Model\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    public function __construct(private CategoryRepository $categoryRepository, private CategoryEntityManager $categoryEntityManager)
    {
    }

    #[Route('/backend/category/list/{categoryId}')]
    public function list(int $categoryId = null): Response
    {
        $categories = $this->categoryRepository->getAll();
        if ($categoryId) {
            $category = $this->categoryRepository->findById($categoryId);
        }

        return $this->render('backend/category/list.html.twig', [
            'categories' => $categories,
            'category' => $category ?? null
        ]);
    }
}