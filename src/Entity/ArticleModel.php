<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/15/18
 * Time: 10:50 PM
 */

namespace App\Entity;


class ArticleModel
{

    private $id;

    private $title;

    private $text;

    private $author;

    private $topicId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ArticleModel
     */
    public  function setId(int $id): ArticleModel
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
     * @return ArticleModel
     */
    public function setTitle($title): ArticleModel
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return ArticleModel
     */
    public function setAuthor($author): ArticleModel
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTopicId()
    {
        return $this->topicId;
    }

    /**
     * @param mixed $topicId
     * @return ArticleModel
     */
    public function setTopicId($topicId): ArticleModel
    {
        $this->topicId = $topicId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     * @return ArticleModel
     */
    public function setText($text): ArticleModel
    {
        $this->text = $text;
        return $this;
    }

}