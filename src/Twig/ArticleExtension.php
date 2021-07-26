<?php

namespace App\Twig;

use App\Service\ArticleService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ArticleExtension extends AbstractExtension
{
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getBannerPath', [$this, 'getBannerPath']),
        ];
    }

    public function getBannerPath(string $category, ?string $slug = null): string
    {
        return $this->articleService->getBannerPath($category, $slug);
    }
}
