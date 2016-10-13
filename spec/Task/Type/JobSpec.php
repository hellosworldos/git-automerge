<?php

namespace spec\Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\Task\Type\Job;
use Hellosworldos\GitTools\Task;
use PhpSpec\ObjectBehavior;
use spec\Hellosworldos\GitTools\Task\Type;
use Prophecy\Argument;

class JobSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Job::class);
    }

    function let(BranchInfoInterface $branchInfo)
    {
        $this->beConstructedWith($branchInfo);
    }

    function it_should_extend_task()
    {
        $this->shouldBeAnInstanceOf(Task::class);
    }
}
