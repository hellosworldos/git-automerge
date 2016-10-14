<?php

namespace spec\Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\GitWrapperInterface;
use Hellosworldos\GitTools\Task\Type\Merge;
use Hellosworldos\GitTools\AbstractTask;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MergeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Merge::class);
        $this->shouldImplement(AbstractTask::class);
    }

    function let(GitWrapperInterface $gitWrapper)
    {
        $this->beConstructedWith('task_name', $gitWrapper);
    }

    function it_runs_merge(BranchInfoInterface $branchInfo)
    {
        $this->run($branchInfo);
    }
}
