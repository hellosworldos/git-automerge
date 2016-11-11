<?php

namespace spec\Hellosworldos\Component\GitTools;

use Hellosworldos\Component\GitTools\AbstractTask;
use Hellosworldos\Component\GitTools\TaskInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

abstract class AbstractTaskSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AbstractTask::class);
        $this->shouldBeAnInstanceOf(TaskInterface::class);
    }
}
