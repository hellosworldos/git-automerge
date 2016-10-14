<?php

namespace spec\Hellosworldos\GitTools;

use Hellosworldos\GitTools\GitWrapperInterface;
use Hellosworldos\GitTools\AbstractTask;
use Hellosworldos\GitTools\TaskInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

abstract class AbstractTaskSpec extends ObjectBehavior
{
    private $gitWrapper;
    private $name;

    function it_is_initializable()
    {
        $this->shouldHaveType(AbstractTask::class);
    }

    function let(GitWrapperInterface $gitWrapper)
    {
        $this->gitWrapper = $gitWrapper;
        $this->name       = 'task_name';
        $this->beConstructedWith($this->name, $this->gitWrapper);
    }

    function it_should_implement_task()
    {
        $this->shouldBeAnInstanceOf(TaskInterface::class);
    }

    function it_should_have_name()
    {
        $this->getName()->shouldBe($this->name);
    }
}
