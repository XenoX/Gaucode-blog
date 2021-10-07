<?php

namespace App\Service;

use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Michelf\Markdown;
use \DateTime;

class CommentService
{
    const FOLDER = 'articles';

    const COMMENTS_FOLDER = 'comments';
    const COMMENTS_AUTHOR_FILENAME = 'author.md';
    const COMMENTS_CONTENT_FILENAME = 'content.md';
    const COMMENTS_DATE_FILENAME = 'date.md';
    
    private string $projectDir;
    private PaginatorInterface $paginator;

    public function __construct(string $projectDir, PaginatorInterface $paginator)
    {
        $this->projectDir = $projectDir;
        $this->paginator = $paginator;
    }

    public function createComment(string $category, string $slug, string $username, string $content)
    {
        $commentsFolder = $this->getFullPath($category, $slug);
        $id = uniqid();
        $postDate = (new DateTime())->format("c");
        $fullPath = $commentsFolder . $id;

        mkdir($fullPath, 0777, true);

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

    public function getArticleComments(string $category, string $slug, int $page)
    {
        $commentsFolder = $this->getFullPath($category, $slug);
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
        $author_path = $this->getRealPath($path, self::COMMENTS_AUTHOR_FILENAME);
        $content_path = $this->getRealPath($path, self::COMMENTS_CONTENT_FILENAME);
        $date_path = $this->getRealPath($path, self::COMMENTS_DATE_FILENAME);

        try {
            $author = file_get_contents($author_path);
            $content = Markdown::defaultTransform(file_get_contents($content_path));
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
        return sprintf('%s/%s/%s/%s/%s/', $this->projectDir, 'public', self::FOLDER, $this->getRealPath($category, $slug), self::COMMENTS_FOLDER);
    }
}