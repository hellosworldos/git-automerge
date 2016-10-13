<?php

namespace spec\Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\Task\Type\Merge;
use Hellosworldos\GitTools\AbstractTask;
use Hellosworldos\GitTools\BranchInfoInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MergeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Merge::class);
        $this->shouldImplement(AbstractTask::class);
    }

    function let(BranchInfoInterface $branchInfo)
    {
        $this->beConstructedWith('task_name', $branchInfo);
    }

    function it_runs_merge()
    {
        $this->run('master', 'result', 'processing');
    }
}
