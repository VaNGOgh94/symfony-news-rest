<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/15/18
 * Time: 9:52 PM
 */

namespace App\Service;


/**
 * Class ErrorService
 * @package App\Service
 *
 * Provides service for error sanctioning
 */
class ErrorService
{
    static $notFoundNum = 10000;
    static $badRequest = 10001;
    static $badRequestExtras = 10002;
    static $serverSideError = 10003;
    static $conflict = 10004;

    private static function buildError($num, $text){
        return array("error"=>array("ernum"=>$num, "text"=>$text));
    }

    public static function buildResourceNotFoundError($id){
        return ErrorService::buildError(ErrorService::$notFoundNum, "Resource with id $id not found!");
    }

    public static function buildBadRequestJsonError($jsonText){
        $jsonText = \str_replace('"',"`",$jsonText);
        return ErrorService::buildError(ErrorService::$badRequest, "Request $jsonText is invalid!");
    }

    public static function buildBadRequestExtrasError($extras)
    {
        return ErrorService::buildError(ErrorService::$badRequestExtras, "Request extras '".(is_array($extras)?implode(' ', $extras):"$extras") ."' invalid!");
    }

    public static function buildServerSideError($error)
    {
        return ErrorService::buildError(ErrorService::$serverSideError, "Server side error: $error");
    }

    public static function buildConflictError($error)
    {
        return ErrorService::buildError(ErrorService::$conflict, "Conflict: $error");
    }

}