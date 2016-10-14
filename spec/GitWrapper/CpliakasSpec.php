<?php

namespace spec\Hellosworldos\GitTools\GitWrapper;

use GitWrapper\GitWorkingCopy;
use Hellosworldos\GitTools\GitWrapper\Cpliakas;
use Hellosworldos\GitTools\GitWrapperInterface;
use Hellosworldos\GitTools\GitWorkspaceInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CpliakasSpec extends ObjectBehavior
{
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
        $this->beConstructedWith($this->workingCopy, $this->workspace);
    }

    function it_must_have_working_copy_in_constructor(GitWorkspaceInterface $workspace)
    {
        $this->beConstructedWith('invalid', $workspace);
        $this->shouldThrow()->duringInstantiation();
    }

    function it_must_have_workspace_in_constructor(GitWorkingCopy $workingCopy)
    {
        $this->beConstructedWith($workingCopy, 'invalid');
        $this->shouldThrow()->duringInstantiation();
    }

    function it_should_merge_branches()
    {
        $toBranch = 'toBranch';


        $this->merge($toBranch, 'joinBranch', [
            GitWrapperInterface::MERGE_NOFF => true
        ])->shouldReturn($this);
    }

    function it_should_checkout_branch()
    {
        $this->workingCopy->checkout(Argument::type('string'))->shouldBeCalled();
        $this->checkout('branchName')->shouldReturn($this);
    }
}
