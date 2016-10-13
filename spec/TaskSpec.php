<?php

namespace spec\Hellosworldos\GitTools;

use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\Task;
use Hellosworldos\GitTools\TaskInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

abstract class TaskSpec extends ObjectBehavior
{
    private $branchInfo;

    function it_is_initializable()
    {
        $this->shouldHaveType(Task::class);
    }

    function let(BranchInfoInterface $branchInfo)
    {
        $this->branchInfo = $branchInfo;
        $this->beConstructedWith($this->branchInfo);
    }

    function it_should_have_branch_info()
    {
        $this->getBranchInfo()->shouldBe($this->branchInfo);
    }

    function it_should_implement_task()
    {
        $this->shouldBeAnInstanceOf(TaskInterface::class);
    }
}
