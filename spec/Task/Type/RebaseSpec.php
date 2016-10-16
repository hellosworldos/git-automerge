<?php

namespace spec\Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\GitWrapperInterface;
use Hellosworldos\GitTools\Task\Type\Rebase;
use Hellosworldos\GitTools\AbstractTask;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RebaseSpec extends ObjectBehavior
{
    private $gitWrapper;

    function it_is_initializable()
    {
        $this->shouldHaveType(Rebase::class);
        $this->shouldImplement(AbstractTask::class);
    }

    function let(GitWrapperInterface $gitWrapper)
    {
        $this->gitWrapper = $gitWrapper;
        $this->beConstructedWith('task_name', $this->gitWrapper);
    }

    function it_runs(BranchInfoInterface $branchInfo)
    {
        $branchInfo->getMasterBranch()->shouldBeCalled()->willReturn('masterBranch');
        $branchInfo->getResultBranch()->shouldBeCalled()->willReturn('resultBranch');
        $branchInfo->getProcessingBranches()->shouldBeCalled()->willReturn(['processing1']);

        $this->gitWrapper
            ->checkout(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->copyBranch(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->rebase(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->removeBranch(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->run($branchInfo)->shouldReturn(true);
    }
}
