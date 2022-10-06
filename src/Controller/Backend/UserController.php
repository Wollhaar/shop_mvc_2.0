<?php
declare(strict_types=1);

namespace App\Controller\Backend;

use App\Model\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository
    )
    {}

     #[Route('/backend/user/list')]
    public function list(Request $request): Response
    {
        return $this->render('backend/user/list.html.twig', [
            'users' => $this->userRepository->getAll()
        ]);
    }
}