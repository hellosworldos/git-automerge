<?php

namespace spec\Hellosworldos\GitTools\GitWrapper;

use GitWrapper\GitWorkingCopy;
use Hellosworldos\GitTools\BranchInfoInterface;
use Hellosworldos\GitTools\GitWrapper\Cpliakas;
use Hellosworldos\GitTools\GitWrapperInterface;
use Hellosworldos\GitTools\GitWorkspaceInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CpliakasSpec extends ObjectBehavior
{
    /**
     * @var GitWorkingCopy
     */
    private $workingCopy;
    private $workspace;

    function it_is_initializable()
    {
        $this->shouldHaveType(Cpliakas::class);
        $this->shouldBeAnInstanceOf(GitWrapperInterface::class);
    }

    function let(GitWorkingCopy $workingCopy, GitWorkspaceInterface $workspace)
    {
        $this->workingCopy = $workingCopy;
        $this->workspace   = $workspace;
        $workingCopy->isCloned()->shouldBeCalled()->willReturn(true);
        $this->beConstructedWith($this->workingCopy, $this->workspace);
    }

    function it_must_have_working_copy_in_constructor(GitWorkspaceInterface $workspace)
    {
        $this->workingCopy->isCloned()->shouldNotBeCalled();
        $this->shouldThrow()->during('__construct', ['invalid', $workspace]);
    }

    function it_must_have_workspace_in_constructor(GitWorkingCopy $workingCopy)
    {
        $this->workingCopy->isCloned()->shouldNotBeCalled();
        $this->shouldThrow()->during('__construct', [$workingCopy, 'invalid']);
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
        $this->workingCopy->merge(Argument::type('string'), Argument::type('array'))->shouldBeCalled();

        $this->merge('joinBranch', [GitWrapperInterface::MERGE_NOFF => true])->shouldReturn($this);
    }

    function it_should_copy_branch()
    {
        $newBranch = 'newBranch';
        $this->workingCopy->branch($newBranch, [GitWrapperInterface::BRANCH_FORCE => true])->shouldBeCalled();

        $this->copyBranch($newBranch)->shouldReturn($this);
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

    function it_should_diff_branches()
    {
        $branch1    = 'branch1';
        $branch2    = 'branch2';
        $outputFile = '/file';
        $this->workingCopy->diff($branch1, $branch2)->shouldBeCalled();

        $this->diff($branch1, $branch2, $outputFile)->shouldReturn($this);
    }
}
