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
    private $gitWrapper;

    function it_is_initializable()
    {
        $this->shouldHaveType(Merge::class);
        $this->shouldImplement(AbstractTask::class);
    }

    function let(GitWrapperInterface $gitWrapper)
    {
        $this->gitWrapper = $gitWrapper;
        $this->beConstructedWith('task_name', $this->gitWrapper);
    }

    function it_runs_merge(BranchInfoInterface $branchInfo)
    {

        $this->gitWrapper
            ->checkout(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->copyBranch(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->merge(Argument::type('string'), Argument::type('array'))
            ->shouldBeCalled();
        $branchInfo->getMasterBranch()->willReturn('string');
        $branchInfo->getProcessingBranches()->willReturn(['processing1']);
        $this->run($branchInfo);
    }
}
