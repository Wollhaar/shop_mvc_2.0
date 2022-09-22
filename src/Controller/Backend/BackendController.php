<?php
declare(strict_types=1);

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackendController extends AbstractController
{
    #[Route('/backend')]
    public function board(): Response
    {
        return $this->render('backend/backend/board.html.twig');
    }
}