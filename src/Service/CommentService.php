<?php

namespace App\Service;

use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Michelf\Markdown;

class CommentService
{
    const FOLDER = 'articles';

    const COMMENTS_FOLDER = 'comments';
    const COMMENTS_AUTHOR_FILENAME = 'author.md';
    const COMMENTS_CONTENT_FILENAME = 'content.md';
    
    private string $projectDir;
    private PaginatorInterface $paginator;

    public function __construct(string $projectDir, PaginatorInterface $paginator)
    {
        $this->projectDir = $projectDir;
        $this->paginator = $paginator;
    }
    public function getArticleComments(string $category, string $slug, int $page)
    {
        $path = sprintf('%s/%s', $category, $slug);

        $commentsFolder = sprintf('%s/%s/%s/%s/%s/', $this->projectDir, 'public', self::FOLDER, $path, self::COMMENTS_FOLDER);
        if (!file_exists($commentsFolder)) {
            mkdir($commentsFolder, 0777, true);
        }
        
        $comments = $this->readComments($commentsFolder);
        return $this->paginator->paginate(
            $comments,
            $page,
            15
        );
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
        $author_path = sprintf('%s/%s', $path, self::COMMENTS_AUTHOR_FILENAME);
        $content_path = sprintf('%s/%s', $path, self::COMMENTS_CONTENT_FILENAME);

        try {
            $author = file_get_contents($author_path);
            $content = Markdown::defaultTransform(file_get_contents($content_path));
        } catch (Exception $exception) {
            throw new NotFoundHttpException();
        }

        return [
            'author' => $author,
            'content' => $content
        ];
    }
}