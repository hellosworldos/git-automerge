<?php

namespace Hellosworldos\GitTools\EventSubscriber;

use GuzzleHttp\Stream\StreamInterface;

interface StreamableInterface
{
    /**
     * @param StreamInterface $stream
     * @return mixed
     */
    public function setStream(StreamInterface $stream);

    /**
     * @return StreamInterface
     */
    public function getStream();

    /**
     * @return $this
     */
    public function unsetStream();

    /**
     * @return bool
     */
    public function hasStream();
}
