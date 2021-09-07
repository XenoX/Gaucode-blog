<?php

namespace App\Controller;

use App\Service\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/auteur/{author}")
     */
    public function profile(AuthorService $authorService, string $author): Response
    {
        return $this->render('author/profile.html.twig', [
            'articles' => $authorService->getAuthorArticles($author),
            'author' => $author,
        ]);
    }
}
