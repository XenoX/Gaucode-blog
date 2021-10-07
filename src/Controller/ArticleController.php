<?php

namespace App\Controller;

use App\Service\ArticleService;
use App\Service\CommentService;
use App\Form\CommentFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{category}/{slug}", name="article_show")
     */
    public function show(string $category, string $slug, ArticleService $articleService, CommentService $commentService, Request $request): Response
    {
        $categories = $articleService->getCategories();
        $page = $request->get('page', 1);
        
        if (!in_array($category, $categories)) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(CommentFormType::class, []); 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $commentService->createComment($category, $slug, strip_tags($data['username']), strip_tags($data['username']));
            return $this->redirectToRoute('article_show', [
                'slug' => $slug,
                'category' => $category
            ]);
        }

        return $this->render('article/show.html.twig', [
            'article' => $articleService->getArticle($category, $slug),
            'comments' => $commentService->getArticleComments($category, $slug, $page),
            'form' => $form->createView()
        ]);
    }
}
