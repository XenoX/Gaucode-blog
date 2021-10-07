<?php

namespace App\Controller;

use App\Service\ArticleService;
use App\Service\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{category}/{slug}")
     */
    public function show(string $category, string $slug, ArticleService $articleService, CommentService $commentService, Request $request): Response
    {
        $categories = $articleService->getCategories();
        $page = $request->get("page", 1);
        
        if (!in_array($category, $categories)) {
            throw new NotFoundHttpException();
        }

        return $this->render('article/show.html.twig', [
            'article' => $articleService->getArticle($category, $slug),
            'comments' => $commentService->getArticleComments($category, $slug, $page)
        ]);
    }
}
