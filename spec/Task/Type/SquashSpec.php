<?php

namespace spec\Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\Task\Type\Squash;
use Hellosworldos\GitTools\GitWrapperInterface;
use Hellosworldos\GitTools\AbstractTask;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SquashSpec extends ObjectBehavior
{
    private $gitWrapper;

    function it_is_initializable()
    {
        $this->shouldHaveType(Squash::class);
        $this->shouldImplement(AbstractTask::class);
    }

    function let(GitWrapperInterface $gitWrapper)
    {
        $this->gitWrapper = $gitWrapper;
        $this->beConstructedWith('task_name', $this->gitWrapper);
    }
}
