<?php
declare(strict_types=1);

namespace App\Controller\Backend;

use App\Model\EntityManager\CategoryEntityManager;
use App\Model\Mapper\CategoriesMapper;
use App\Model\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private CategoryEntityManager $categoryEntityManager,
        private CategoriesMapper $categoriesMapper
    )
    {}

    #[Route('/backend/category/list')]
    public function list(): Response
    {
        $categories = $this->categoryRepository->getAll();

        return $this->render('backend/category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/backend/category/create')]
    public function create(Request $request): Response
    {
        $category = ['id' => 0, 'active' => true];
        $category['name'] = $request->request->get('name');

        if (!empty($category['name'])) {
            $categoryDTO = $this->categoryEntityManager->addCategory(
                $this->categoriesMapper->mapToDto($category)
            );
        }
        return $this->render('backend/category/create.html.twig', [
            'category' => $categoryDTO ?? null
        ]);
    }

    #[Route('/backend/category/delete/{categoryId}')]
    public function delete(int $categoryId): Response
    {
        $this->categoryEntityManager->delete($categoryId);

        return $this->render('backend/category/list.html.twig', [
            'categories' => $this->categoryRepository->getAll(),
            'category' => null
        ]);
    }
}