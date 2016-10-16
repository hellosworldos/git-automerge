<?php

namespace spec\Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\Task\Type\Squash;
use Hellosworldos\GitTools\GitWrapperInterface;
use Hellosworldos\GitTools\AbstractTask;
use Symfony\Component\Filesystem\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SquashSpec extends ObjectBehavior
{
    private $gitWrapper;
    private $filesystem;

    function it_is_initializable()
    {
        $this->shouldHaveType(Squash::class);
        $this->shouldImplement(AbstractTask::class);
    }

    function let(GitWrapperInterface $gitWrapper, Filesystem $filesystem)
    {
        $this->gitWrapper = $gitWrapper;
        $this->filesystem = $filesystem;

        $this->beConstructedWith('task_name', $this->gitWrapper);
        $this->setFilesystem($this->filesystem);
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
            ->diff(Argument::type('string'), Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->apply(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->run($branchInfo)->shouldReturn(true);
    }

    function it_should_have_filesystem(Filesystem $filesystem)
    {
        $this->setFilesystem($filesystem)->shouldReturn($this);
        $this->getFilesystem()->shouldReturn($filesystem);
    }

    function it_expects_set_filesystem_to_be_typed(Filesystem $filesystem)
    {
        $this->shouldThrow()->during('setFilesystem', ['string']);
        $this->shouldThrow()->during('setFilesystem', []);
    }
}
