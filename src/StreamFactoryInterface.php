<?php

namespace Hellosworldos\GitTools;

use GuzzleHttp\Stream\StreamInterface;

interface StreamFactoryInterface
{
    /**
     * @param string $filename
     * @return StreamInterface
     */
    public function factory($filename);
}
