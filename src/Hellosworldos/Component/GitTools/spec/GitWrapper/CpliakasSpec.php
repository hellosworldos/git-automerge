<?php

namespace spec\Hellosworldos\Component\GitTools\GitWrapper;

use GitWrapper\GitWorkingCopy;
use GitWrapper\GitWrapper;
use GitWrapper\GitException;
use GuzzleHttp\Stream\StreamInterface;
use Hellosworldos\Component\GitTools\EventSubscriber\StreamableInterface;
use Hellosworldos\Component\GitTools\GitWrapper\Cpliakas;
use Hellosworldos\Component\GitTools\GitWrapper\Exception;
use Hellosworldos\Component\GitTools\GitWrapperInterface;
use Hellosworldos\Component\GitTools\GitWorkspaceInterface;
use Hellosworldos\Component\GitTools\StreamFactoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CpliakasSpec extends ObjectBehavior
{
    /**
     * @var GitWorkingCopy
     */
    private $workingCopy;
    private $workspace;
    private $streamFactory;

    /**
     * @var StreamableInterface
     */
    private $streamableEventSubscriber;
    /**
     * @var GitWrapper
     */
    private $gitWrapper;

    function it_is_initializable()
    {
        $this->shouldHaveType(Cpliakas::class);
        $this->shouldBeAnInstanceOf(GitWrapperInterface::class);
    }

    function let(
        GitWorkingCopy $workingCopy,
        GitWorkspaceInterface $workspace,
        StreamFactoryInterface $streamFactory,
        GitWrapper $gitWrapper,
        StreamableInterface $streamableEventSubscriber
    )
    {
        $this->workingCopy               = $workingCopy;
        $this->workspace                 = $workspace;
        $this->streamFactory             = $streamFactory;
        $this->gitWrapper                = $gitWrapper;
        $this->streamableEventSubscriber = $streamableEventSubscriber;

        $workingCopy->isCloned()->shouldBeCalled()->willReturn(true);
        $workingCopy->getWrapper()->shouldBeCalled()->willReturn($gitWrapper);
        $this->beConstructedWith($workingCopy, $workspace, $streamFactory, $streamableEventSubscriber);
    }

    function it_must_have_working_copy_in_constructor(GitWorkspaceInterface $workspace)
    {
        $this->workingCopy->isCloned()->shouldNotBeCalled();
        $this->workingCopy->getWrapper()->shouldNotBeCalled();
        $this->shouldThrow()->during('__construct', ['invalid', $workspace]);
    }

    function it_must_have_streamFactory_in_constructor(
        GitWorkingCopy $workingCopy,
        GitWorkspaceInterface $workspace
    )
    {
        $this->workingCopy->isCloned()->shouldNotBeCalled();
        $this->workingCopy->getWrapper()->shouldNotBeCalled();

        $this->shouldThrow()->during('__construct', [$workingCopy, $workspace]);
        $this->shouldThrow()->during('__construct', [$workingCopy, $workspace, 'string']);
    }

    function it_must_have_workspace_in_constructor(GitWorkingCopy $workingCopy)
    {
        $this->workingCopy->isCloned()->shouldNotBeCalled();
        $this->workingCopy->getWrapper()->shouldNotBeCalled();
        $this->shouldThrow()->during('__construct', [$workingCopy, 'invalid']);
    }

    function it_must_have_streamableEventSubscriber_in_constructor(
        GitWorkingCopy $workingCopy,
        GitWorkspaceInterface $workspace,
        StreamFactoryInterface $streamFactory,
        StreamableInterface $streamableEventSubscriber
    )
    {
        $this->shouldThrow()->during('__construct', [$workingCopy, $workspace, $streamFactory]);
        $this->shouldThrow()->during('__construct', [$workingCopy, $workspace, $streamFactory, 'string']);
        $this->shouldNotThrow()->during('__construct', [$workingCopy, $workspace, $streamFactory, $streamableEventSubscriber]);
    }

    function it_should_throw_exception_if_merge_called_without_first_2_params()
    {
        $this->shouldThrow()->during('merge', ['string', 'string', 'notarray']);
        $this->shouldThrow()->during('merge', ['string']);
        $this->shouldThrow()->during('merge', []);
    }

    function it_should_checkout_branch()
    {
        $this->workingCopy->checkout(Argument::type('string'))->shouldBeCalled();
        $this->checkout('branchName')->shouldReturn($this);
    }

    function it_should_merge_branches()
    {
        $options = [GitWrapperInterface::MERGE_NOFF => true];
        $this->workingCopy->merge(Argument::type('string'), $options)->shouldBeCalled();

        $this->merge('joinBranch', $options)->shouldReturn($this);
    }

    function it_should_throw_own_exception_on_merge()
    {
        $this->workingCopy->merge(Argument::type('string'), Argument::type('array'))->willThrow(GitException::class);

        $this->shouldThrow(Exception::class)->during('merge', ['joinBranch', []]);
    }

    function it_should_abort_merge()
    {
        $options = [GitWrapperInterface::MERGE_ABORT => true];
        $this->workingCopy->merge($options)->shouldBeCalled();

        $this->mergeAbort()->shouldReturn($this);
    }

    function it_should_copy_branch()
    {
        $newBranch = 'newBranch';
        $this->workingCopy->branch($newBranch, [GitWrapperInterface::BRANCH_FORCE => true])->shouldBeCalled();

        $this->copyBranch($newBranch)->shouldReturn($this);
    }

    function it_should_clean()
    {
        $this->workingCopy->clean()->shouldBeCalled();

        $this->clean()->shouldReturn($this);
    }

    function it_should_stash()
    {
        $this->workingCopy->run([Cpliakas::STASH])->shouldBeCalled();

        $this->stash()->shouldReturn($this);
    }

    function it_should_remove_branch()
    {
        $branch = 'removedBranch';
        $this->workingCopy
            ->branch($branch, [
                GitWrapperInterface::BRANCH_FORCE  => true,
                GitWrapperInterface::BRANCH_DELETE => true,
            ])
            ->shouldBeCalled();

        $this->removeBranch($branch)->shouldReturn($this);
    }

    function it_should_rebase_branch()
    {
        $branch = 'branch';
        $this->workingCopy->rebase($branch)->shouldBeCalled();

        $this->rebase($branch)->shouldReturn($this);
    }

    function it_should_diff_branches(StreamInterface $stream)
    {
        $branch1    = 'branch1';
        $branch2    = 'branch2';
        $outputFile = '/file';
        $this->gitWrapper->streamOutput(true)->shouldBeCalled();
        $this->streamableEventSubscriber->setStream($stream)->shouldBeCalled();
        $this->workingCopy->diff($branch1, $branch2)->shouldBeCalled();
        $this->streamFactory->makeWritableFile($outputFile)->shouldBeCalled()->willReturn($stream);
        $this->gitWrapper->streamOutput(false)->shouldBeCalled();
        $this->streamableEventSubscriber->unsetStream()->shouldBeCalled();
        $stream->close()->shouldBeCalled();

        $this->diff($branch1, $branch2, $outputFile)->shouldReturn($this);
    }

    function it_should_apply_diff_file()
    {
        $filename = '/tmp/file';

        $this->workingCopy->apply($filename)->shouldBeCalled();

        $this->apply($filename)->shouldReturn($this);
    }

    function it_should_commit_changes()
    {
        $message = 'commit message';

        $this->workingCopy->commit($message)->shouldBeCalled();

        $this->commit($message)->shouldReturn($this);
    }

    function it_should_abort_rebase()
    {
        $options = [GitWrapperInterface::REBASE_ABORT => true];
        $this->workingCopy->rebase($options)->shouldBeCalled();

        $this->rebaseAbort()->shouldReturn($this);
    }
}
