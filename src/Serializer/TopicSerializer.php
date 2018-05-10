<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/17/18
 * Time: 10:08 AM
 */

namespace App\Serializer;


use App\Entity\TopicModel;

/**
 * Class TopicSerializer
 * @package App\Serializer
 *
 * Holds logic for serializing topics
 */
class TopicSerializer
{

    public static function serializeTopicMandatory(TopicModel $topicModel)
    {
        return array(
            "id" => $topicModel->getId(),
            "title" => $topicModel->getTitle()
        );
    }

    public static function serializeTopicArrayMandatory(?array $topicArray):?array
    {
        $serializedArray = array();
        if(isset($topicArray))
        {
            foreach ($topicArray as $topic)
            {
                $serializedArray[] = TopicSerializer::serializeTopicMandatory($topic);
            }
        }
        return $serializedArray;
    }

    public static function serializeTopicListMandatory(?array $topicArray)
    {
        return array(
                    "count"=>count($topicArray),
                    "items"=>TopicSerializer::serializeTopicArrayMandatory($topicArray)

        );
    }


    public static function serializeTopicFull(TopicModel $topicModel)
    {
        return array(
            "id" => $topicModel->getId(),
            "title" => $topicModel->getTitle(),
            "articles" =>
                array(
                    "count"=> count($topicModel->getArticles()),
                    "items"=>ArticleSerializer::serializeArticleArrayMandatory($topicModel->getArticles())
                )
        );
    }

    public static function serializeTopicArrayFull(?array $topicArray):?array
    {
        $serializedArray = array();
        if(isset($topicArray))
        {
            foreach ($topicArray as $topic)
            {
                $serializedArray[] = TopicSerializer::serializeTopicFull($topic);
            }
        }
        return $serializedArray;
    }

    public static function serializeTopicListFull(?array $topicArray)
    {
        return array(
            "topics"=>
                array(
                    "count"=>count($topicArray),
                    "items"=>TopicSerializer::serializeTopicArrayFull($topicArray)
                )
        );
    }




}