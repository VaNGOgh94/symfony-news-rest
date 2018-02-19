<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/15/18
 * Time: 10:49 PM
 */

namespace App\Dao;


use App\DatabaseInterface;
use App\Entity\ArticleModel;

class ArticleDao
{
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
        $this->db->connect();
    }

    private function createArticleFromAssoc(array $assocArticle):ArticleModel
    {
        return (new ArticleModel())
            ->setId($assocArticle["id"])
            ->setTitle($assocArticle["title"])
            ->setAuthor($assocArticle["author"])
            ->setText($assocArticle["text"])
            ->setTopicId($assocArticle["topic_id"]);
    }

    /**
     * @param ArticleModel $articleModel
     *
     *  Executes mocked query for creating
     * @return ArticleModel|null
     */
    private function create(ArticleModel $articleModel):?ArticleModel
    {
        $query = "INSERT INTO article (title, author, text, topic_id) VALUES ('{$articleModel->getTitle()}', '{$articleModel->getAuthor()}','{$articleModel->getText()}',{$articleModel->getTopicId()})";
        try{
            $newId = $this->db->insertQuery($query);
            if(!isset($newId))
                return null;
            $articleModel->setId($newId);
            return $articleModel;
        }
        catch (\Throwable $ex){
            return null;
        }
    }

    /**
     * @param ArticleModel $articleModel
     *
     * Executes query for updating
     * @return ArticleModel|null
     */
    private function update(ArticleModel $articleModel):?ArticleModel
    {
        //throw new \Exception("Not Implemented");
        return null;
    }


    /**
     * @param ArticleModel $articleModel
     *
     * Saves model (update or insert)
     * @return ArticleModel|null
     */
    public function save(ArticleModel $articleModel):?ArticleModel
    {
        $modelId = $articleModel->getId();
        if(isset($modelId) && $modelId>0)
        {
            return $this->update($articleModel);
        }
        else
        {
            return $this->create($articleModel);
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
            $query = "DELETE FROM article WHERE id = $id";
            return $this->db->otherQuery($query);
        }
        catch (\Throwable $ex)
        {
            return false;
        }
    }


    /**
     * @param $id
     * @return ArticleModel
     *
     * Executes mocked select query
     */
    public function findById($id):?ArticleModel
    {
        try{
            $articleModel = null;
            $data = $this->db->selectQuery("SELECT * FROM article a WHERE a.id = $id");
            if($data->num_rows >= 1){
                $data = $data->fetch_assoc();
                $articleModel = $this->createArticleFromAssoc($data);
            }
            return $articleModel;
        }
        catch (\Throwable $ex){
            return null;
        }

    }

    public function findAll():?array
    {
        try{
            $articleArray = array();
            $data = $this->db->selectQuery("SELECT * FROM article");
            while($row = $data->fetch_assoc())
            {
                $articleModel = $this->createArticleFromAssoc($row);
                $articleArray[] = $articleModel;
            }
            return $articleArray;
        }
        catch (\Throwable $ex){
            return null;
        }
    }


    public function findAllByTopicId(int $topicId):?array
    {
        try{
            $articleArray = array();
            $query = "SELECT * FROM article a WHERE a.topic_id=$topicId;";
            $data = $this->db->selectQuery($query);
            if(isset($data) && $data != false)
            {
                while($row = $data->fetch_assoc())
                {
                    $articleModel = $this->createArticleFromAssoc($row);
                    $articleArray[] = $articleModel;
                }
            }
            return $articleArray;
        }
        catch (\Throwable $ex){
            return null;
        }
    }


}