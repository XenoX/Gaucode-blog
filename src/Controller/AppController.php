<?php

namespace App\Controller;

use App\Service\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig', []);
    }

    #[Route('/contribuer')]
    public function contribute(AuthorService $authorService): Response
    {
        return $this->render('app/contribute.html.twig', [
            'authors' => $authorService->getAuthors(),
        ]);
    }

    #[Route('/a-propos')]
    public function about(): Response
    {
        return $this->render('app/about.html.twig', []);
    }
}
