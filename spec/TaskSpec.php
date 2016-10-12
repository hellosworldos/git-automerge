<?php

namespace spec\Hellosworldos\GitTools;

use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\Task;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Task::class);
    }

    function it_should_allow_to_set_branch_info(BranchInfoInterface $branchInfo)
    {
        $this->setBranchInfo($branchInfo)->shouldBeAnInstanceOf(Task::class);
        $this->getBranchInfo()->shouldBeAnInstanceOf(BranchInfoInterface::class);
    }

    function its_allowed_to_add_subtask()
    {
        $this->addSubtask();
    }
}
