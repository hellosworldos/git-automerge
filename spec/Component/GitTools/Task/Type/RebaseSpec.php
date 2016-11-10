<?php

namespace spec\Hellosworldos\Component\GitTools\Task\Type;

use Hellosworldos\Component\GitTools\BranchInfoInterface;
use Hellosworldos\Component\GitTools\GitWrapperInterface;
use Hellosworldos\Component\GitTools\Task\Type\Rebase;
use Hellosworldos\Component\GitTools\GitWrapper\Exception;
use Hellosworldos\Component\GitTools\AbstractTask;
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
        $this->beConstructedWith($this->gitWrapper);
    }

    function it_runs(BranchInfoInterface $branchInfo)
    {
        $masterBranch       = 'masterBranch';
        $resultBranch       = 'resultBranch';
        $processingBranches = ['processing1', 'processing2'];

        $branchInfo->getMasterBranch()->shouldBeCalled()->willReturn($masterBranch);
        $branchInfo->getResultBranch()->shouldBeCalled()->willReturn($resultBranch);
        $branchInfo->getProcessingBranches()->shouldBeCalled()->willReturn($processingBranches);

        $this->gitWrapper
            ->stash()
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->clean()
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->checkout($masterBranch)
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        foreach ($processingBranches as $processingBranch) {
            $this->gitWrapper
                ->checkout(Argument::type('string'))
                ->shouldBeCalled()
                ->willReturn($this->gitWrapper);

            $this->gitWrapper
                ->checkout($processingBranch)
                ->shouldBeCalled()
                ->willReturn($this->gitWrapper);

            $this->gitWrapper
                ->rebase($masterBranch)
                ->shouldBeCalled()
                ->willReturn($this->gitWrapper);

            $this->gitWrapper
                ->rebase(Argument::type('string'))
                ->shouldBeCalled()
                ->willReturn($this->gitWrapper);

            $this->gitWrapper
                ->copyBranch(Argument::type('string'))
                ->shouldBeCalled()
                ->willReturn($this->gitWrapper);
        }

        $this->gitWrapper
            ->copyBranch(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->removeBranch(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->checkout($resultBranch)
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->run($branchInfo)->shouldReturn(true);
    }

    function it_runs_and_handles_rebase_error(BranchInfoInterface $branchInfo)
    {
        $masterBranch       = 'master';
        $resultBranch       = 'result';
        $processingBranches = ['processing1', 'processing2'];

        $this->gitWrapper->clean()->willReturn($this->gitWrapper);
        $this->gitWrapper->stash()->willReturn($this->gitWrapper);
        $this->gitWrapper->checkout(Argument::type('string'))->willReturn($this->gitWrapper);
        $this->gitWrapper->copyBranch(Argument::type('string'))->willReturn($this->gitWrapper);
        $this->gitWrapper->removeBranch(Argument::type('string'))->willReturn($this->gitWrapper);

        $branchInfo->getMasterBranch()->shouldBeCalled()->willReturn($masterBranch);
        $branchInfo->getResultBranch()->shouldBeCalled()->willReturn($resultBranch);
        $branchInfo->getProcessingBranches()->shouldBeCalled()->willReturn($processingBranches);

        foreach ($processingBranches as $processingBranch) {
            $this->gitWrapper
                ->rebase(Argument::type('string'))
                ->willThrow(Exception::class);

            $this->gitWrapper->rebaseAbort()
                ->shouldBeCalled();
        }

        $this->run($branchInfo)->shouldReturn(false);
        $this->getExceptions()->shouldHaveCount(count($processingBranches));
    }

    function it_should_have_name()
    {
        $this->getName()->shouldBe(Rebase::NAME);
    }
}
