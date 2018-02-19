<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/17/18
 * Time: 10:09 AM
 */

namespace App\Serializer;


use App\Entity\ArticleModel;

/**
 * Class ArticleSerializer
 * @package App\Serializer
 *
 * Holds logic for serializing articles
 */
class ArticleSerializer
{

    public static function serializeArticleMandatory(ArticleModel $articleModel)
    {
        return array(
            "id" => $articleModel->getId(),
            "title" => $articleModel->getTitle(),
            "text" => $articleModel->getText(),
            "author" =>$articleModel->getAuthor()
        );
    }

    public static function serializeArticleArrayMandatory(?array $articleArray)
    {
        $serializedArray = array();
        if(isset($articleArray))
        {
            foreach ($articleArray as $article)
            {
                $serializedArray[] = ArticleSerializer::serializeArticleMandatory($article);
            }
        }
        return $serializedArray;
    }


    public static function serializeArticleFull(ArticleModel $articleModel)
    {
        $data = ArticleSerializer::serializeArticleMandatory($articleModel);
        $data["topicId"] = $articleModel->getTopicId();
        return $data;
    }


}