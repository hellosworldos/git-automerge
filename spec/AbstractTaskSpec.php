<?php

namespace spec\Hellosworldos\GitTools;

use Hellosworldos\GitTools\AbstractTask;
use Hellosworldos\GitTools\TaskInterface;
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
