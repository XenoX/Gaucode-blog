<?php

namespace App\Tests\Service;

use App\Service\ArticleService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleServiceTest extends TestCase
{
    private const PROJECT_DIR = __DIR__.'/../data';

    public function testGetCategoriesWithoutCategoryShouldReturnEmptyArray(): void
    {
        $value = (new ArticleService(sprintf('%s/%s', self::PROJECT_DIR, 'empty')))->getCategories();

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    public function testGetCategoriesWithCategoriesShouldReturnArray(): void
    {
        $value = (new ArticleService(sprintf('%s/%s', self::PROJECT_DIR, 'filled')))->getCategories();

        $this->assertIsArray($value);
        $this->assertSame(['one', 'two'], $value);
    }

    public function testGetCategoryWithoutFileShouldThrowAnException(): void
    {
        $this->expectException(NotFoundHttpException::class);

        (new ArticleService(sprintf('%s/%s', self::PROJECT_DIR, 'empty')))->getCategory('void');
    }

    public function testGetCategoryWithFilesShouldReturnArray(): void
    {
        $value = (new ArticleService(sprintf('%s/%s', self::PROJECT_DIR, 'filled')))->getCategory('one');

        $this->assertIsArray($value);
        $this->assertSame([
            'slug' => 'one',
            'title' => 'title',
            'shortname' => 'shortname',
            'articles' => [],
        ], $value);
    }

    public function testGetArticleWithoutArticleShouldThrowAnException(): void
    {
        $this->expectException(NotFoundHttpException::class);

        (new ArticleService(sprintf('%s/%s', self::PROJECT_DIR, 'empty')))->getArticle('one', 'void');
    }

    public function testGetArticleShouldReturnAnArray(): void
    {
        $value = (new ArticleService(sprintf('%s/%s', self::PROJECT_DIR, 'filled')))->getArticle('two', 'article-slug');

        $this->assertIsArray($value);
        $this->assertSame($this->getData()[0], $value);
    }

    public function testGetArticlesForCategoryShouldReturnArray(): void
    {
        $value = (new ArticleService(sprintf('%s/%s', self::PROJECT_DIR, 'filled')))->getArticlesForCategory('two');

        $this->assertIsArray($value);
        $this->assertSame($this->getData(), $value);
    }

    public function testGetArticlesWithoutArticlesShouldReturnEmptyArray(): void
    {
        $value = (new ArticleService(sprintf('%s/%s', self::PROJECT_DIR, 'empty')))->getArticles();

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    public function testGetArticlesWithArticlesShouldReturnArray(): void
    {
        $value = (new ArticleService(sprintf('%s/%s', self::PROJECT_DIR, 'filled')))->getArticles();

        $this->assertIsArray($value);
        $this->assertSame($this->getData(), $value);
    }

    public function testGetBannerPathWithoutSlugShouldReturnStringPath(): void
    {
        $value = (new ArticleService(sprintf('%s/%s', self::PROJECT_DIR, 'filled')))->getBannerPath('two');

        $this->assertIsString($value);
        $this->assertSame('articles/two/banner.jpg', $value);
    }

    public function testGetBannerPathShouldReturnStringPath(): void
    {
        $value = (new ArticleService(sprintf('%s/%s', self::PROJECT_DIR, 'filled')))->getBannerPath('two', 'article-slug');

        $this->assertIsString($value);
        $this->assertSame('articles/two/article-slug/banner.jpg', $value);
    }

    private function getData(): array
    {
        return [
            [
                'category' => 'two',
                'slug' => 'article-slug',
                'title' => 'title',
                'subtitle' => 'subtitle',
                'content' => "<p>content</p>\n",
                'author' => 'author',
            ],
            [
                'category' => 'two',
                'slug' => 'article-two-slug',
                'title' => 'title',
                'subtitle' => 'subtitle',
                'content' => "<p>content</p>\n",
                'author' => 'author',
            ],
        ];
    }
}
