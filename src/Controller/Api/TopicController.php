<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/15/18
 * Time: 11:48 AM
 */

namespace App\Controller\Api;


use App\Entity\TopicModel;
use App\Exception\GeneralException;
use App\Exception\InvalidExtrasException;
use App\Exception\ResourceNotFoundException;
use App\Facade\TopicFacade;
use App\Service\ErrorService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TopicController
 * @package App\Controller\Api
 * @Route("/api/topics")
 *
 * Represents interface over HTTP for Management System for topics
 * Supports partial REST service - specific topic (and topic list) can be
 * fetched with or without "extras" which for now include articles
 */
class TopicController extends Controller
{
    private $topicFacade;
    public function  __construct(TopicFacade $topicFacade)
    {
        $this->topicFacade = $topicFacade;
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

        if(!isset($data["title"]))
        {
            $responseData = ErrorService::buildBadRequestJsonError($request->getContent());
            $status = 400;
        }
        else
        {
            try {
                $newTopic = new TopicModel();
                $newTopic->setTitle($data["title"]);
                $responseData = $this->topicFacade->createAndReturnTopic($newTopic);
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
     * @Route("/{topicId}", name="topic_delete", requirements={"topicId"="\d+"})
     * @Method("DELETE")
     * @param $topicId
     * @param Request $request
     * @return Response
     */
    public function deleteAction($topicId, Request $request)
    {

        $status = null;
        $responseData = null;
        $deleteSuccessful = $this->topicFacade->deleteTopic($topicId);
        if($deleteSuccessful)
        {
            $status = 204;
        }
        else
        {
            $responseData = ErrorService::buildConflictError("Unable to delete topic, delete articles first!");
            $status = 409;
        }
        return new Response(json_encode($responseData), $status);
    }

    /**
     * @Route("/{topicId}", name="topic_show", requirements={"topicId"="\d+"})
     * @Method("GET")
     * @param $topicId
     * @param Request $request
     * @return Response
     */
    public function showAction($topicId, Request $request)
    {
        $extras = $request->query->get('extras');
        $responseData = null;
        $status = null;
        try{
            if(isset($extras))
            {
                try
                {
                    $responseData = $this->topicFacade->fetchTopicWithExtras($topicId, $extras);
                    $status = 200;
                }
                catch (InvalidExtrasException $ex)
                {
                    $responseData = ErrorService::buildBadRequestExtrasError($extras);
                    $status = 400;
                }
            }
            else
            {
                $responseData = $this->topicFacade->fetchTopic($topicId);
                $status = 200;
            }
        }
        catch (ResourceNotFoundException $ex)
        {
            $responseData = ErrorService::buildResourceNotFoundError($topicId);
            $status = 404;
        }

        return new Response(json_encode($responseData, JSON_NUMERIC_CHECK), $status);
    }

    /**
     * @Route("")
     * @Method("GET")
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
//        $starttime = microtime(true);
//        $i = 0;
//        while($i<10000) {
//            $i++;

            $extras = $request->query->get('extras');
            $responseData = null;
            $status = null;
            if (isset($extras)) {
                try {
                    $responseData = $this->topicFacade->fetchAllTopicsWithExtras($extras);
                    $status = 200;
                } catch (InvalidExtrasException $ex) {
                    $responseData = ErrorService::buildBadRequestExtrasError($extras);
                    $status = 400;
                }
            } else {
                $responseData = $this->topicFacade->fetchAllTopics();
                $status = 200;
            }
//        }
//        echo "duration: ".(microtime(true) - $starttime);
        return new Response(json_encode($responseData, JSON_NUMERIC_CHECK), $status);
    }

}