<?php

declare(strict_types=1);

namespace App\Service;

use Michelf\MarkdownExtra;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ArticleService
{
    const FOLDER = 'articles';
    const TITLE_FILENAME = 'title.md';
    const SHORTNAME_FILENAME = 'shortname.md';
    const SUBTITLE_FILENAME = 'subtitle.md';
    const CONTENT_FILENAME = 'content.md';
    const AUTHOR_FILENAME = 'author.md';
    const BANNER_FILENAME = 'banner.jpg';

    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function getCategories(): array
    {
        $categoriesPath = sprintf('%s/%s/%s/*', $this->projectDir, 'public', self::FOLDER);
        $categoryPaths = glob($categoriesPath, GLOB_ONLYDIR);

        return $this->sanitizePaths($categoryPaths);
    }

    public function getCategory(string $slug): array
    {
        return [
            'slug' => $slug,
            'title' => $this->getFileContent($slug, self::TITLE_FILENAME),
            'shortname' => $this->getFileContent($slug, self::SHORTNAME_FILENAME),
            'articles' => $this->getArticlesForCategory($slug),
        ];
    }

    public function getArticle(string $category, string $slug): array
    {
        $path = sprintf('%s/%s', $category, $slug);

        return [
            'category' => $category,
            'slug' => $slug,
            'title' => $this->getFileContent($path, self::TITLE_FILENAME),
            'subtitle' => $this->getFileContent($path, self::SUBTITLE_FILENAME),
            'content' => MarkdownExtra::defaultTransform($this->getFileContent($path, self::CONTENT_FILENAME)),
            'author' => $this->getFileContent($path, self::AUTHOR_FILENAME),
        ];
    }

    public function getArticlesForCategory(string $category): array
    {
        $articlesPath = sprintf('%s/%s/%s/%s/*', $this->projectDir, 'public', self::FOLDER, $category);
        $articles = [];

        foreach ($this->sanitizePaths(glob($articlesPath, GLOB_ONLYDIR)) as $slug) {
            $articles[] = $this->getArticle($category, $slug);
        }

        return $articles;
    }

    public function getArticles(): array
    {
        $articles = [];
        foreach ($this->getCategories() as $category) {
            $articles = array_merge($articles, $this->getArticlesForCategory($category));
        }

        return $articles;
    }

    public function getBannerPath(string $category, string $slug = null): string
    {
        $articleOrCategoryPath = $slug ? sprintf('%s/%s', $category, $slug) : $category;
        $path = sprintf('%s/%s/%s/%s/%s', $this->projectDir, 'public', self::FOLDER, $articleOrCategoryPath, self::BANNER_FILENAME);

        if (file_exists($path)) {
            return sprintf('%s/%s/%s', self::FOLDER, $articleOrCategoryPath, self::BANNER_FILENAME);
        }

        return sprintf('%s/%s/%s', self::FOLDER, $category, self::BANNER_FILENAME);
    }

    private function getFileContent(string $path, string $filename): string
    {
        try {
            $content = file_get_contents(
                sprintf(
                    '%s/%s/%s/%s/%s',
                    $this->projectDir,
                    'public',
                    self::FOLDER,
                    $path,
                    $filename,
                )
            );
        } catch (Throwable) {
            throw new NotFoundHttpException();
        }

        return $content;
    }

    private function sanitizePaths(array $paths): array
    {
        return array_map(function ($path) {
            $exploded = explode('/', $path);
            return end($exploded);
        }, $paths);
    }
}