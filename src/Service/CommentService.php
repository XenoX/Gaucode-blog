<?php

declare(strict_types=1);

namespace App\Service;

use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentService
{
    const COMMENTS_FOLDER = 'comments';
    const COMMENTS_AUTHOR_FILENAME = 'author.md';
    const COMMENTS_CONTENT_FILENAME = 'content.md';
    const COMMENTS_DATE_FILENAME = 'date.md';
    
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function create(string $category, string $slug, string $username, string $content)
    {
        $commentsFolder = $this->getFullPath($category, $slug);

        $postDate = date("c");
        $fullPath = $commentsFolder . uniqid();

        mkdir($fullPath);

        $this->createFile(
            $this->getRealPath($fullPath, self::COMMENTS_AUTHOR_FILENAME),
            $username
        );
        $this->createFile(
            $this->getRealPath($fullPath, self::COMMENTS_CONTENT_FILENAME),
            $content
        );
        $this->createFile(
            $this->getRealPath($fullPath, self::COMMENTS_DATE_FILENAME),
            $postDate
        );
    }

    public function getArticleComments(string $category, string $slug)
    {
        $commentsFolder = $this->getFullPath($category, $slug);
        if (!file_exists($commentsFolder)) {
            mkdir($commentsFolder);
        }
        
        return array_reverse($this->readComments($commentsFolder));
    }

    private function readComments(string $path)
    {
        $commentsDir = scandir($path);
        $commentsDir = array_slice($commentsDir, 2, count($commentsDir));
        $comments = array_map(function($comment) use ($path) {
            $fullPath = sprintf('%s%s', $path, $comment); 
            return $this->parseCommentData($fullPath);
        }, $commentsDir);

       return $comments;
    }

    private function parseCommentData(string $path)
    {
        $author_path = $this->getRealPath($path, self::COMMENTS_AUTHOR_FILENAME);
        $content_path = $this->getRealPath($path, self::COMMENTS_CONTENT_FILENAME);
        $date_path = $this->getRealPath($path, self::COMMENTS_DATE_FILENAME);

        try {
            $author = file_get_contents($author_path);
            $content = file_get_contents($content_path);
            $date = file_get_contents($date_path);
        } catch (Exception $exception) {
            throw new NotFoundHttpException();
        }

        return [
            'author' => $author,
            'content' => $content,
            'date' => $date
        ];
    }

    private function createFile(string $path, string $data)
    {
        file_put_contents($path, $data);
    }

    private function getRealPath(string $path, string $filename)
    {
        return sprintf('%s/%s', $path, $filename);
    }
    private function getFullPath(string $category, string $slug)
    {
        return sprintf('%s/%s/%s/%s/%s/', $this->projectDir, 'public', ArticleService::FOLDER, $this->getRealPath($category, $slug), self::COMMENTS_FOLDER);
    }
}