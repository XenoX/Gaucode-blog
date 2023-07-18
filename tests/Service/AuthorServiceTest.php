<?php

namespace App\Tests\Service;

use App\Service\ArticleService;
use App\Service\AuthorService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AuthorServiceTest extends TestCase
{
    private ArticleService|MockObject $articleService;

    public function setUp(): void
    {
        $this->articleService = $this->createMock(ArticleService::class);
    }

    public function testGetAuthorsWithoutAuthorShouldReturnEmptyArray(): void
    {
        $this->articleService->expects($this->once())->method('getArticles')->willReturn([]);

        $value = (new AuthorService($this->articleService))->getAuthors();

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    public function testGetAuthorsWithAuthorShouldReturnArray(): void
    {
        $this->articleService->expects($this->once())->method('getArticles')->willReturn($this->getData());

        $value = (new AuthorService($this->articleService))->getAuthors();

        $this->assertIsArray($value);
        $this->assertSame([
            'User 1' => 3,
            'User 2' => 1,
            'User 3' => 1,
            'User 4' => 2,
        ], $value);
    }

    public function testGetAuthorsWithWrongFormatShouldReturnEmptyArray(): void
    {
        $this->articleService->expects($this->once())->method('getArticles')->willReturn([[], []]);

        $value = (new AuthorService($this->articleService))->getAuthors();

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    public function testGetAuthorsArticlesWithoutArticlesShouldReturnEmptyArray(): void
    {
        $this->articleService->expects($this->once())->method('getArticles')->willReturn([]);

        $value = (new AuthorService($this->articleService))->getAuthorArticles('User 4');

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    public function testGetAuthorsArticlesWithArticlesShouldReturnArray(): void
    {
        $this->articleService->expects($this->once())->method('getArticles')->willReturn($this->getData());

        $value = (new AuthorService($this->articleService))->getAuthorArticles('User 4');

        $this->assertIsArray($value);
        $this->assertSame([
            ['author' => 'User 4'],
            ['author' => 'User 4'],
        ], $value);
    }

    public function testGetAuthorsArticlesWithWrongFormatShouldReturnArray(): void
    {
        $this->articleService->expects($this->once())->method('getArticles')->willReturn([[], []]);

        $value = (new AuthorService($this->articleService))->getAuthorArticles('User 4');

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    private function getData(): array
    {
        return [
            ['author' => 'User 1'],
            ['author' => 'User 1'],
            ['author' => 'User 1'],
            ['author' => 'User 2'],
            ['author' => 'User 3'],
            ['author' => 'User 4'],
            ['author' => 'User 4'],
        ];
    }
}
