<?php

namespace spec\Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\Task\Type\Squash;
use Hellosworldos\GitTools\GitWrapperInterface;
use Hellosworldos\GitTools\AbstractTask;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SquashSpec extends ObjectBehavior
{
    /**
     * @var GitWrapperInterface
     */
    private $gitWrapper;
    private $streamFactory;

    function it_is_initializable()
    {
        $this->shouldHaveType(Squash::class);
        $this->shouldImplement(AbstractTask::class);
    }

    function let(GitWrapperInterface $gitWrapper)
    {
        $this->gitWrapper = $gitWrapper;

        $this->beConstructedWith($this->gitWrapper);
    }

    function it_expects_gitwrapper_for_constructor(GitWrapperInterface $gitWrapper)
    {
        $this->shouldThrow()->during('__construct', []);
        $this->shouldNotThrow()->during('__construct', [$gitWrapper]);
        $this->shouldThrow()->during('__construct', ['notGitWrapper']);
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

        // @TODO call remove patch file

        $this->run($branchInfo)->shouldReturn(true);
    }

//    function it_should_have_stream_factory(StreamFactory $streamFactory)
//    {
//        $this->setStreamFactory($streamFactory)->shouldReturn($this);
//        $this->getStreamFactory()->shouldReturn($streamFactory);
//    }
//
//    function it_expects_set_filesystem_to_be_typed(Filesystem $filesystem)
//    {
//        $this->shouldThrow()->during('setFilesystem', ['string']);
//        $this->shouldThrow()->during('setFilesystem', []);
//    }

    function it_should_have_name()
    {
        $this->getName()->shouldBe(Squash::NAME);
    }
}
