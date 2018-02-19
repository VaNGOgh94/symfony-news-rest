<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/17/18
 * Time: 10:43 AM
 */

namespace App\Facade;


use App\Entity\ArticleModel;
use App\Exception\ResourceNotFoundException;
use App\Serializer\ArticleSerializer;
use App\Service\ArticleService;
use App\Exception\GeneralException;

class ArticleFacade
{
    private $articleService;
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * @param ArticleModel $articleModel
     * @return array
     * @throws GeneralException
     */
    public function createAndReturnArticle(ArticleModel $articleModel)
    {
        $newArticle = $this->articleService->saveArticle($articleModel);
        if($newArticle != null)
        {
            $articleData = array();
            $articleData["article"] = ArticleSerializer::serializeArticleFull($newArticle);
            return $articleData;
        }
        else
        {
            throw new GeneralException( "Cannot create article", 0);
        }
    }

    /**
     * @param int $articleId
     * @return array|null
     * @throws ResourceNotFoundException
     */
    public function fetchArticle(int $articleId): ?array
    {
        $article = $this->articleService->findArticle($articleId);
        if (isset($article)) {
            $topicData = array();
            $topicData["article"] = ArticleSerializer::serializeArticleFull($article);
            return $topicData;
        } else
            throw new ResourceNotFoundException('Resource article with id $articleId not found', 0);
    }

    public function deleteArticle(int $articleId):bool
    {
        return $this->articleService->deleteArticle($articleId);
    }

}