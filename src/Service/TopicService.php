<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/15/18
 * Time: 2:21 PM
 */

namespace App\Service;
use App\Dao\TopicDao;
use App\Entity\TopicModel;

/**
 * Class TopicService
 * @package App\Service
 *
 * Layer that uses repositories and does logic regarding data usage
 * The use case is so simple that this service doesn't have any internal logic
 */
class TopicService
{
    private $topicDao;

    public function __construct(TopicDao $topicDao)
    {
        $this->topicDao = $topicDao;
    }

    public function saveTopic(TopicModel $topicModel):?TopicModel
    {
        return $this->topicDao->save($topicModel);
    }

    public function findTopic($id): ?TopicModel
    {
        return $this->topicDao->findById($id);
    }

    public function deleteTopic($id):bool
    {
        return $this->topicDao->delete($id);
    }

    public function findAllTopics():?array
    {
        return $this->topicDao->findAll();
    }

}