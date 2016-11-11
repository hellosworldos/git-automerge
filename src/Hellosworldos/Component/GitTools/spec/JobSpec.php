<?php

namespace spec\Hellosworldos\Component\GitTools;

use Hellosworldos\Component\GitTools\BranchInfoInterface;
use Hellosworldos\Component\GitTools\Task\RegistryInterface;
use Hellosworldos\Component\GitTools\Job;
use Hellosworldos\Component\GitTools\Job\Result;
use Hellosworldos\Component\GitTools\TaskInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JobSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Job::class);
    }

    function it_can_have_task(TaskInterface $task)
    {
        $taskName = 'sample_task';
        $task->getName()->shouldBeCalled()->willReturn($taskName);
        $this->addTask($task)->shouldReturn($this);
        $this->getTask($taskName)->shouldReturn($task);
    }

    function it_should_return_the_list_of_all_tasks(TaskInterface $task)
    {
        $this->getTasks()->shouldReturn([]);
        $numberOfTasks = 5;
        for ($i = 0; $i < $numberOfTasks; $i++) {
            $taskName = 'sample_task'.$i;
            $task->getName()->shouldBeCalled()->willReturn($taskName);
            $this->addTask($task)->shouldReturn($this);
        }

        $this->getTasks()->shouldHaveCount($numberOfTasks);
        $this->getTasks()->shouldContain($task);
    }

    function it_should_run_with_branch_info(BranchInfoInterface $branchInfo)
    {
        //$branchInfo->getMasterBranch()->shouldBeCalled();
        $this->run($branchInfo)->shouldReturnAnInstanceOf(Result::class);
    }
}
