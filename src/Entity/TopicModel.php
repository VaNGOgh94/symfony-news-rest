<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/15/18
 * Time: 1:03 PM
 */

namespace App\Entity;



class TopicModel
{
    private $id;

    private $title;

    private $articles;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return TopicModel
     */
    public  function setId($id): TopicModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return TopicModel
     */
    public function setTitle($title): TopicModel
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param mixed $articles
     * @return TopicModel
     */
    public function setArticles($articles): TopicModel
    {
        $this->articles = $articles;
        return $this;
    }


}