<?php

namespace App\Controller;

use App\Service\ArticleService;
use Michelf\Markdown;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{category}/{slug}")
     */
    public function show(string $category, string $slug, ArticleService $articleService): Response
    {
        $categories = $articleService->getCategories();
        if (!in_array($category, $categories)) {
            throw new NotFoundHttpException();
        }

        return $this->render('article/show.html.twig', [
            'article' => $articleService->getArticle($category, $slug),
        ]);
    }
}
