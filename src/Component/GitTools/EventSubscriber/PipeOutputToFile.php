<?php

namespace Hellosworldos\Component\GitTools\EventSubscriber;

use GitWrapper\Event\GitEvents;
use GitWrapper\Event\GitOutputEvent;
use GuzzleHttp\Stream\StreamInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Process\Process;

class PipeOutputToFile implements EventSubscriberInterface, StreamableInterface
{
    private $stream;

    public static function getSubscribedEvents()
    {
        return [GitEvents::GIT_OUTPUT => 'onGitOutput'];
    }

    /**
     * @param GitOutputEvent $event
     */
    public function onGitOutput(GitOutputEvent $event)
    {
        if ($this->hasStream() && $event->getType() == Process::OUT) {
            $this->getStream()->write($event->getBuffer());
        }
    }

    public function setStream(StreamInterface $stream)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * @return $this
     */
    public function unsetStream()
    {
        $this->stream = null;

        return $this;
    }

    public function hasStream()
    {
        return !is_null($this->stream);
    }
}
