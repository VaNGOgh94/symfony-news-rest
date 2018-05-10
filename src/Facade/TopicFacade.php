<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/15/18
 * Time: 10:24 PM
 */

namespace App\Facade;


use App\Entity\TopicModel;
use App\Exception\GeneralException;
use App\Exception\InvalidExtrasException;
use App\Exception\ResourceNotFoundException;
use App\Serializer\TopicSerializer;
use App\Service\ArticleService;
use App\Service\TopicService;

/**
 * Class TopicFacade
 * @package App\Facade
 *
 * TopicFacade is facade for all TopicModel related logic.
 * It represents simplified interface for various clients (in this specific case TopicController)
 * for manipulating TopicModel data.
 */
class TopicFacade
{
    private $topicService;
    private $articleService;

    public function __construct(TopicService $topicService, ArticleService $articleService)
    {
        $this->articleService = $articleService;
        $this->topicService = $topicService;
    }

    /**
     * @param int $topicId
     * @return array|null
     * @throws ResourceNotFoundException
     */
    public function fetchTopic(int $topicId): ?array
    {
        $topic = $this->topicService->findTopic($topicId);
        if (isset($topic)) {
            $topicData = TopicSerializer::serializeTopicMandatory($topic);
            return $topicData;
        } else
            throw new ResourceNotFoundException('Resource topic with id $topicId not found', 0);
    }

    public function topicExtrasValid($extras)
    {
        return count($extras) === 1 && is_array($extras) && in_array("articles", $extras);
    }

    /**
     * @param int $topicId
     * @param array $extras
     * @return array|null
     * @throws InvalidExtrasException
     * @throws ResourceNotFoundException
     */
    public function fetchTopicWithExtras(int $topicId, $extras): ?array
    {

        if ($this->topicExtrasValid($extras)) {
            $topic = $this->topicService->findTopic($topicId);
            if (isset($topic)) {
                $articles = $this->articleService->findAllByTopicId($topic->getId());
                $topic->setArticles($articles);

                $topicData = TopicSerializer::serializeTopicFull($topic);
                return $topicData;
            } else
                throw new ResourceNotFoundException('Resource topic with id $topicId not found', 0);
        } else {
            throw new InvalidExtrasException('Topic fields are not valid', 0);
        }
    }

    public function fetchAllTopics()
    {
        $topicArray = $this->topicService->findAllTopics();

        $topicData = TopicSerializer::serializeTopicListMandatory($topicArray);
        return $topicData;
    }

    /**
     * @param $extras
     * @return array|null
     * @throws InvalidExtrasException
     */
    public function fetchAllTopicsWithExtras($extras): ?array
    {
        if ($this->topicExtrasValid($extras)) {
            $topicArray = $this->topicService->findAllTopics();

            if(isset($topicArray))
            {
                foreach ($topicArray as $topic)
                {
                    $articles = $this->articleService->findAllByTopicId($topic->getId());
                    $topic->setArticles($articles);
                }
            }
            $topicData = TopicSerializer::serializeTopicListFull($topicArray);
            return $topicData;

        } else {
            throw new InvalidExtrasException('Topic fields are not valid', 0);
        }
    }

    /**
     * @param TopicModel $topicModel
     * @return array|null
     * @throws GeneralException
     */
    public function createAndReturnTopic(TopicModel $topicModel):?array
    {
        $newTopic = $this->topicService->saveTopic($topicModel);
        if($newTopic != null)
        {
            $topicData = TopicSerializer::serializeTopicMandatory($newTopic);
            return $topicData;
        }
        else
        {
            throw new GeneralException( "Cannot create topic", 0);
        }
    }

    public function deleteTopic($topicId):?bool
    {
        return $this->topicService->deleteTopic($topicId);
    }


}