<?php

namespace spec\Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\Task\Type\Squash;
use Hellosworldos\GitTools\GitWrapperInterface;
use Hellosworldos\GitTools\AbstractTask;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Filesystem\Filesystem;

class SquashSpec extends ObjectBehavior
{
    /**
     * @var GitWrapperInterface
     */
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

        $this->beConstructedWith($this->gitWrapper, $this->filesystem);
    }

    function it_expects_gitwrapper_for_constructor(GitWrapperInterface $gitWrapper, Filesystem $filesystem)
    {
        $this->shouldThrow()->during('__construct', []);
        $this->shouldThrow()->during('__construct', ['notGitWrapper']);
        $this->shouldThrow()->during('__construct', [$gitWrapper]);
        $this->shouldThrow()->during('__construct', [$gitWrapper, 'not_filesystem']);
        $this->shouldNotThrow()->during('__construct', [$gitWrapper, $filesystem]);
    }

    function it_runs(BranchInfoInterface $branchInfo)
    {
        $masterBranch     = 'masterBranch';
        $resultBranch     = 'resultBranch';
        $processingBranch = 'processing1';
        $branchInfo->getMasterBranch()->shouldBeCalled()->willReturn($masterBranch);
        $branchInfo->getResultBranch()->shouldBeCalled()->willReturn($resultBranch);
        $branchInfo->getProcessingBranches()->shouldBeCalled()->willReturn([$processingBranch]);

        $this->gitWrapper
            ->checkout($masterBranch)
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->copyBranch($resultBranch)
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->checkout($resultBranch)
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->diff($masterBranch, $processingBranch, Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->apply(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->gitWrapper
            ->commit(Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($this->gitWrapper);

        $this->filesystem->remove(Argument::type('string'))->shouldBeCalled();

        $this->run($branchInfo)->shouldReturn(true);
    }

    function it_should_have_name()
    {
        $this->getName()->shouldBe(Squash::NAME);
    }
}
