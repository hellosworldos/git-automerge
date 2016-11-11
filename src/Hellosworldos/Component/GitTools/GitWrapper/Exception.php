<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 10/26/16
 * Time: 10:53 PM
 */

namespace Hellosworldos\Component\GitTools\GitWrapper;


class Exception extends \Exception implements ExceptionDecoratorInterface {
    private $nextException;

    /**
     * @return \Exception
     */
    public function getNextException()
    {
        return $this->nextException;
    }

    /**
     * @param \Exception $exception
     * @return $this
     */
    public function setNextException(\Exception $exception)
    {
        $this->nextException = $exception;

        return $this;
    }
}