<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/15/18
 * Time: 1:26 PM
 */

namespace App\Dao;


use App\DatabaseInterface;
use App\Entity\TopicModel;

/**
 * Class TopicDao
 * @package App\Repository
 *
 * Topic Data Access Object
 */
class TopicDao
{
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
        $this->db->connect();
    }

    private function createTopicFromAssoc(array $assocTopic):TopicModel
    {
        $topicModel = new TopicModel();
        $topicModel
            ->setId($assocTopic["id"])
            ->setTitle($assocTopic["title"]);
        return $topicModel;
    }

    /**
     * @param $id
     * @return TopicModel
     *
     * Executes mocked select query
     */
    public function findById($id):?TopicModel
    {
        try{
            $topicModel = null;
            $data = $this->db->selectQuery("SELECT * FROM topic t WHERE t.id = $id");
            if($data->num_rows >= 1){
                $data = $data->fetch_assoc();
                $topicModel = $this->createTopicFromAssoc($data);
            }
            return $topicModel;
        }
        catch (\Throwable $ex){
            return null;
        }

    }

    /**
     * @param TopicModel $topicModel
     *
     *  Executes mocked query for creating
     * @return TopicModel|null
     */
    private function create(TopicModel $topicModel):?TopicModel
    {
        $query = "INSERT INTO topic (title) VALUES('{$topicModel->getTitle()}');";
        try{
            $newId = $this->db->insertQuery($query);
            if(!isset($newId))
                return null;
            $topicModel->setId($newId);
            return $topicModel;
        }
        catch (\Throwable $ex){
            return null;
        }
    }

    /**
     * @param TopicModel $topicModel
     *
     * Executes query for updating
     * @return TopicModel|null
     */
    private function update(TopicModel $topicModel):?TopicModel
    {
        //throw new \Exception("Not Implemented");
        return null;
    }

    /**
     * @param TopicModel $topicModel
     *
     * Saves model (update or insert)
     * @return TopicModel|null
     */
    public function save(TopicModel $topicModel):?TopicModel
    {
        $modelId = $topicModel->getId();
        if(isset($modelId) && $modelId>0)
        {
            return $this->update($topicModel);
        }
        else
        {
            return $this->create($topicModel);
        }
    }

    /**
     * @param int $id
     * @return bool
     * Executes mocked query for deleting
     * Returns true if success, false if fail
     */
    public function delete(int $id):bool
    {
        try
        {
            $query = "DELETE FROM topic WHERE id = $id";
            return $this->db->otherQuery($query);
        }
        catch (\Throwable $ex)
        {
            return false;
        }
    }

    /**
     * @return array|null
     */
    public function findAll()
    {

        try{
            $topicArray = array();
            $data = $this->db->selectQuery("SELECT * FROM topic");
            if(isset($data) && $data != false)
            {
                while($row = $data->fetch_assoc())
                {
                    $topicModel = $this->createTopicFromAssoc($row);
                    $topicArray[] = $topicModel;
                }
            }
            return $topicArray;
        }
        catch (\Throwable $ex){
            return null;
        }
    }

}