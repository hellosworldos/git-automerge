<?php

namespace spec\Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\GitWrapperInterface;
use Hellosworldos\GitTools\GitWrapper\Exception;
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
        $this->beConstructedWith($gitWrapper);

        $this->gitWrapper
            ->checkout(Argument::type('string'))
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->copyBranch(Argument::type('string'))
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->merge(Argument::type('string'), Argument::type('array'))
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->removeBranch(Argument::type('string'))
            ->willReturn($this->gitWrapper);
    }

    function it_constructs_with_dependencies(GitWrapperInterface $gitWrapper)
    {
        $this->shouldThrow()->during('__construct', []);
        $this->shouldThrow()->during('__construct', ['not_git_wrapper']);
        $this->shouldNotThrow()->during('__construct', [$gitWrapper]);
    }

    function it_runs(BranchInfoInterface $branchInfo)
    {
        $masterBranch       = 'master';
        $resultBranch       = 'result';
        $processingBranches = ['processing1', 'processing2'];

        $branchInfo->getMasterBranch()->shouldBeCalled()->willReturn($masterBranch);
        $branchInfo->getResultBranch()->shouldBeCalled()->willReturn($resultBranch);
        $branchInfo->getProcessingBranches()->shouldBeCalled()->willReturn($processingBranches);

        $this->gitWrapper
            ->checkout($masterBranch)
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->checkout($resultBranch)
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->checkout(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->copyBranch(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        foreach ($processingBranches as $processingBranch) {
            $this->gitWrapper
                ->checkout($processingBranch)
                ->shouldBeCalled()
                ->willReturn($this->gitWrapper);

            $this->gitWrapper
                ->merge($processingBranch, [GitWrapperInterface::MERGE_NOFF => true])
                ->shouldBeCalled()
                ->willReturn($this->gitWrapper);
        }

        $this->gitWrapper
            ->copyBranch($resultBranch)
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->removeBranch(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->run($branchInfo)->shouldReturn(true);
    }

    function it_runs_and_handles_merge_error(BranchInfoInterface $branchInfo)
    {
        $masterBranch       = 'master';
        $resultBranch       = 'result';
        $processingBranches = ['processing1', 'processing2'];

        $branchInfo->getMasterBranch()->shouldBeCalled()->willReturn($masterBranch);
        $branchInfo->getResultBranch()->shouldBeCalled()->willReturn($resultBranch);
        $branchInfo->getProcessingBranches()->shouldBeCalled()->willReturn($processingBranches);

        foreach ($processingBranches as $processingBranch) {
            $this->gitWrapper
                ->merge($processingBranch, [GitWrapperInterface::MERGE_NOFF => true])
                ->willThrow(Exception::class);

            $this->gitWrapper->mergeAbort()
                ->shouldBeCalled();
        }

        $this->run($branchInfo)->shouldReturn(false);
        $this->getExceptions()->shouldHaveCount(count($processingBranches));
    }

    function it_should_have_name()
    {
        $this->getName()->shouldBe(Merge::NAME);
    }
}

