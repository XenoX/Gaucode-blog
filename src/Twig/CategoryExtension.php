<?php

namespace App\Twig;

use App\Service\ArticleService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoryExtension extends AbstractExtension
{
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getCategories', [$this, 'getCategories']),
        ];
    }

    public function getCategories(): array
    {
        return $this->articleService->getCategories();
    }
}
