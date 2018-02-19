<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/15/18
 * Time: 11:07 PM
 */

namespace App\Service;


use App\Dao\ArticleDao;
use App\Entity\ArticleModel;

/**
 * Class ArticleService
 * @package App\Service
 *
 * Layer that uses repositories and does logic regarding data usage
 * The use case is so simple that this service doesn't have any internal logic
 */
class ArticleService
{
    private $articleDao;
    public function __construct(ArticleDao $articleDao)
    {
        $this->articleDao = $articleDao;
    }

    public function findAllByTopicId(int $topicId):?array
    {
        return $this->articleDao->findAllByTopicId($topicId);
    }

    public function saveArticle(ArticleModel $articleModel):?ArticleModel
    {
        return $this->articleDao->save($articleModel);
    }


    public function findArticle($id): ?ArticleModel
    {
        return $this->articleDao->findById($id);
    }

    public function deleteArticle($id):?bool
    {
        return $this->articleDao->delete($id);
    }
}