<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/15/18
 * Time: 10:41 PM
 */

namespace App\Exception;


class InvalidExtrasException extends \Exception
{

    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}