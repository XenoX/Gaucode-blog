<?php

declare(strict_types=1);

namespace App\Service;

class AuthorService
{
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function getAuthors(): array
    {
        $authors = [];

        foreach ($this->articleService->getArticles() as $article) {
            if (!array_key_exists('author', $article)) {
                continue;
            }

            if (!array_key_exists($article['author'], $authors)) {
                $authors[$article['author']] = 0;
            }
            $authors[$article['author']] = ++$authors[$article['author']];
        }

        return $authors;
    }

    public function getAuthorArticles(string $author): array
    {
        foreach ($articles = $this->articleService->getArticles() as $key => $article) {
            if (array_key_exists('author', $article) && $author === $article['author']) {
                continue;
            }

            unset($articles[$key]);
        }

        return array_values($articles);
    }
}
