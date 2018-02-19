<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/17/18
 * Time: 11:53 AM
 */

namespace App\Tests;



use App\Entity\ArticleModel;
use App\Exception\GeneralException;
use App\Exception\ResourceNotFoundException;
use App\Facade\ArticleFacade;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ArticleFacadeUTest extends TestCase
{
    private function makeTestArticlemodel()
    {
        return (new ArticleModel())
            ->setId(1)
            ->setText("text")
            ->setAuthor("author")
            ->setTitle("title");
    }

    /**
     * @throws \Exception
     */
    public function testCreateAndReturnArticle()
    {
        $articleModel = $this->makeTestArticlemodel();
        $articleService = $this->createMock(ArticleService::class);
        $articleService->expects($this->at(0))
            ->method('saveArticle')
            ->willReturn($articleModel);
        $articleService->expects($this->at(1))
            ->method('saveArticle')
            ->willReturn(null);

        $articleFacade = new ArticleFacade($articleService);
        try {
            $result = $articleFacade->createAndReturnArticle($articleModel);
            $this->assertTrue(is_array($result), "ArticleFacade createAndReturnArticle method should've returned array but it hasn't");
            $this->assertTrue(isset($result["article"]), "ArticleFacade createAndReturnArticle method returned array but it didn't have article element inside");
        } catch (GeneralException $e) {
            $this->assertTrue(false, "ArticleFacade createAndReturnArticle method threw exception when it shouldn't have!{$e->getMessage()}");
        }

        //testing exception throwing for case in which articleService returns null
        $this->expectException(GeneralException::class,"ArticleFacade createAndReturnArticle method should've thrown exception but id didn't");
        $articleFacade->createAndReturnArticle(new ArticleModel());
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function testFetchArticle()
    {
        $articleId = 1;
        $articleModel = $this->makeTestArticlemodel();

        $articleService = $this->createMock(ArticleService::class);
        $articleService->expects($this->at(0))
            ->method('findArticle')
            ->willReturn($articleModel);
        $articleService->expects($this->at(1))
            ->method('findArticle')
            ->willReturn(null);

        $articleFacade = new ArticleFacade($articleService);
        try {
            $result = $articleFacade->fetchArticle($articleId);
            $this->assertTrue(is_array($result), "ArticleFacade fetchArticle method should've returned array but it didn't");
            $this->assertTrue(isset($result["article"]), "ArticleFacade fetchArticle method returned array but it didn't have article element inside");
        } catch (ResourceNotFoundException $e) {
            $this->assertTrue(false, "ArticleFacade fetchArticle method threw exception when it shouldn't have!{$e->getMessage()}");
        }

        //testing exception throwing for case in which articleService returns null
        $this->expectException(ResourceNotFoundException::class,"ArticleFacade fetchArticle method should throw exception but it didn't");
        $articleFacade->fetchArticle($articleId);
    }

    public function testDeleteArticle()
    {
        $articleService = $this->createMock(ArticleService::class);
        $articleService->expects($this->at(0))
            ->method('deleteArticle')
            ->willReturn(true);
        $articleService->expects($this->at(1))
            ->method('deleteArticle')
            ->willReturn(false);
        $articleFacade = new ArticleFacade($articleService);
        self::assertTrue($articleFacade->deleteArticle(0), "ArticleFacade delete method returned false but it shouldn't have");
        self::assertFalse($articleFacade->deleteArticle(0), "ArticleFacade delete method returned true but it shouldn't have");
    }

}