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
        $this->beConstructedWith($this->gitWrapper);
    }

    function it_runs(BranchInfoInterface $branchInfo)
    {
        $branchInfo->getMasterBranch()->shouldBeCalled();
        $branchInfo->getResultBranch()->shouldBeCalled()->willReturn('resultBranch');
        $branchInfo->getProcessingBranches()->shouldBeCalled();

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
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->removeBranch(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $branchInfo->getMasterBranch()->willReturn('string');
        $branchInfo->getProcessingBranches()->willReturn(['processing1']);
        $this->run($branchInfo)->shouldReturn(true);
    }

    function it_should_have_name()
    {
        $this->getName()->shouldBe(Merge::NAME);
    }
}
