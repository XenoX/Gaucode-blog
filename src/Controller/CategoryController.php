<?php

namespace App\Controller;

use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categorie/{slug}")
     */
    public function show(string $slug, ArticleService $articleService): Response
    {
        $category = $articleService->getCategory($slug);

        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
