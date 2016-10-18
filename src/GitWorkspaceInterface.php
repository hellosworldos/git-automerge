<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 10/15/16
 * Time: 12:03 AM
 */

namespace Hellosworldos\GitTools;


interface GitWorkspaceInterface
{
    /**
     * @return string
     */
    public function getPubKeyPath();

    /**
     * @return string
     */
    public function getRemoteUrl();
}