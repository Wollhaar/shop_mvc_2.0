<?php
declare(strict_types=1);

namespace App\Controller\Backend;

use App\Model\EntityManager\CategoryEntityManager;
use App\Model\Mapper\CategoriesMapper;
use App\Model\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private CategoryEntityManager $categoryEntityManager,
        private CategoriesMapper $categoriesMapper)
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

    #[Route('/backend/category/add')]
    public function add(): Response
    {
        return $this->render('backend/category/add.html.twig');
    }

    #[Route('/backend/category/create/{category}', methods: ['POST'])]
    public function create(array $category): Response
    {
        $category['id'] = 0;
        $category['active'] = true;

        $id = $this->categoryEntityManager->addCategory(
            $this->categoriesMapper->mapToDto($category)
        );
        return $this->render('backend/category/create.html.twig', [
            'category' => $this->categoryRepository->findById($id)
        ]);
    }

    #[Route('/backend/category/delete/{categoryId}')]
    public function delete(int $categoryId): Response
    {
        $this->categoryEntityManager->delete($categoryId);

        return $this->render('backend/category/list.html.twig', [
            'categories' => $this->categoryRepository->getAll()
        ]);
    }
}