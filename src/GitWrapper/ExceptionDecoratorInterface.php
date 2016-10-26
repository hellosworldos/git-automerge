<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 10/26/16
 * Time: 11:24 PM
 */

namespace Hellosworldos\GitTools\GitWrapper;

interface ExceptionDecoratorInterface
{
    /**
     * @return \Exception
     */
    public function getNextException();
} 