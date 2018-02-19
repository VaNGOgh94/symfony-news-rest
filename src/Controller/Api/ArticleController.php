<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/17/18
 * Time: 10:49 AM
 */

namespace App\Controller\Api;


use App\Entity\ArticleModel;
use App\Exception\GeneralException;
use App\Exception\ResourceNotFoundException;
use App\Facade\ArticleFacade;
use App\Service\ErrorService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ArticleController
 * @package App\Controller\Api
 * @Route("/api/articles")
 *
 * Represents interface over HTTP for Management System for articles
 *
 * ListAction is not implemented here because TopicController supports
 * listing articles for specific topic
 */

class ArticleController extends Controller
{
    private $articleFacade;
    public function __construct(ArticleFacade $articleFacade)
    {
        $this->articleFacade = $articleFacade;
    }


    /**
     * @Route("")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $responseData = null;
        $status = null;
        $data = json_decode($request->getContent(), true);

        if(!isset($data["title"])
            ||!isset($data["author"])
            ||!isset($data["text"])
            ||!isset($data["topicId"]))
        {
            $responseData = ErrorService::buildBadRequestJsonError($request->getContent());
            $status = 400;
        }
        else
        {
            try {
                $newArticle = new ArticleModel();
                $newArticle ->setTitle($data["title"])
                            ->setAuthor($data["author"])
                            ->setText($data["text"])
                            ->setTopicId($data["topicId"]);
                $responseData = $this->articleFacade->createAndReturnArticle($newArticle);
                $status = 201;
            }
            catch (GeneralException $ex)
            {
                $responseData = ErrorService::buildServerSideError($ex->getMessage());
                $status = 500;
            }
        }

        return new Response(json_encode($responseData, JSON_NUMERIC_CHECK), $status);
    }


    /**
     * @Route("/{articleId}", name="article_show", requirements={"articleId"="\d+"})
     * @Method("GET")
     * @param $articleId
     * @return Response
     */
    public function showAction($articleId)
    {
        $responseData = null;
        $status = null;
        try{
            $responseData = $this->articleFacade->fetchArticle($articleId);
            $status = 200;
        }
        catch (ResourceNotFoundException $ex)
        {
            $responseData = ErrorService::buildResourceNotFoundError($articleId);
            $status = 404;
        }
        return new Response(json_encode($responseData, JSON_NUMERIC_CHECK), $status);
    }

    /**
     * @Route("/{articleId}", name="article_delete", requirements={"articleId"="\d+"})
     * @Method("DELETE")
     * @param $articleId
     * @param Request $request
     * @return Response
     */
    public function deleteAction($articleId, Request $request)
    {

        $status = null;
        $responseData = null;
        $deleteSuccessful = $this->articleFacade->deleteArticle($articleId);
        if($deleteSuccessful)
        {
            $status = 204;
        }
        else
        {
            $responseData = ErrorService::buildServerSideError("Failed to delete article!");
            $status = 500;
        }
        return new Response(json_encode($responseData), $status);
    }


}