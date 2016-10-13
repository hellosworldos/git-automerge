<?php

namespace spec\Hellosworldos\GitTools;

use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\AbstractTask;
use Hellosworldos\GitTools\TaskInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

abstract class AbstractTaskSpec extends ObjectBehavior
{
    private $branchInfo;
    private $name;

    function it_is_initializable()
    {
        $this->shouldHaveType(Task::class);
    }

    function let(BranchInfoInterface $branchInfo)
    {
        $this->branchInfo = $branchInfo;
        $this->name       = 'task_name';
        $this->beConstructedWith($this->name, $this->branchInfo);
    }

    function it_should_have_branch_info()
    {
        $this->getBranchInfo()->shouldBe($this->branchInfo);
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
