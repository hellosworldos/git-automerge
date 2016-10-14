<?php

namespace spec\Hellosworldos\GitTools\GitWrapper;

use GitWrapper\GitWrapper;
use Hellosworldos\GitTools\GitWrapper\Cpliakas;
use Hellosworldos\GitTools\GitWrapperInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CpliakasSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Cpliakas::class);
    }

    function let(GitWrapper $gitWrapper)
    {
        $this->beConstructedWith($gitWrapper);
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
        $this->checkout('branchName');
    }
}
