<?php

use App\Service\CommentService;

require_once 'vendor/autoload.php';

class Fixtures
{
    private string $articlesDir;
    private Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
        $this->articlesDir = realpath("./public/" . CommentService::FOLDER);
    }
    
    public function start()
    {
        $categories = $this->parseContent($this->articlesDir);

        foreach ($categories as $category) {
            $content = $this->parseContent($this->getRealPath($this->articlesDir, $category));
            
            $articles = array_filter($content, function($file) {
                if (!str_contains($file, ".")) {
                    return  $file;
                }
            });

            foreach ($articles as $article) {
                $this->handleArticle($this->getRealPath($category, $article));
            }
        }
    }

    private function handleArticle(string $article)
    {
        $fullPath = $this->getRealPath($this->articlesDir, $article);
        $commentsDir = $this->getRealPath($fullPath, CommentService::COMMENTS_FOLDER);
        if (!file_exists($commentsDir)) {
            mkdir($commentsDir, 0777, true);
        }

        for ($i=0;$i<12;++$i) {
            $this->createNewComment($commentsDir);
        }
    }

    private function createNewComment(string $commentsDir)
    {
        $id = uniqid();
        $realDir = $this->getRealPath($commentsDir, $id);
        mkdir($realDir, 0777, true);
        file_put_contents(
            $this->getRealPath($realDir, CommentService::COMMENTS_AUTHOR_FILENAME),
            $this->faker->name()
        );
        file_put_contents(
            $this->getRealPath($realDir, CommentService::COMMENTS_CONTENT_FILENAME),
            $this->faker->paragraphs()
        );
        file_put_contents(
            $this->getRealPath($realDir, CommentService::COMMENTS_DATE_FILENAME),
            $this->faker->time("c")
        );
    }

    private function getRealPath(string $path, string $dirOrFile)
    {
        return sprintf("%s/%s", $path, $dirOrFile);
    }
    
    private function parseContent(string $dir)
    {
        $content = scandir($dir);
        $content = array_slice($content, 2, count($content));
        return $content;
    }
}

(new Fixtures)->start();

echo "\n";