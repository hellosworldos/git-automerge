<?php

namespace Hellosworldos\Component\GitTools;

use GuzzleHttp\Stream\StreamInterface;

interface StreamFactoryInterface
{
    /**
     * @param string $filename
     * @return StreamInterface
     */
    public function makeWritableFile($filename);
}
