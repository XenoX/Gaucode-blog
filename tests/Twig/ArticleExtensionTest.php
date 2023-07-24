<?php

namespace App\Tests\Twig;

use App\Service\ArticleService;
use App\Twig\ArticleExtension;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Twig\TwigFunction;

class ArticleExtensionTest extends TestCase
{
    private ArticleService|MockObject $articleService;

    public function setUp(): void
    {
        $this->articleService = $this->createMock(ArticleService::class);
    }

    public function testGetFunctionShouldReturnAnArrayOfTwigFunctions(): void
    {
        $value = (new ArticleExtension($this->articleService))->getFunctions();

        $this->assertIsIterable($value);
        $this->assertContainsOnlyInstancesOf(TwigFunction::class, $value);
    }
}
