<?php

namespace spec\Hellosworldos\GitTools;

use Hellosworldos\GitTools\BranchInfo;
use Hellosworldos\GitTools\BranchInfoInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BranchInfoSpec extends ObjectBehavior
{
    private $masterBranch;
    private $resultBranch;
    private $processingBranches = [];

    function it_is_initializable()
    {
        $this->shouldHaveType(BranchInfo::class);
    }

    function let()
    {
        $this->masterBranch       = 'master';
        $this->resultBranch       = 'result';
        $this->processingBranches = ['processing1', 'processing2'];

        $this->beConstructedWith($this->masterBranch, $this->resultBranch, $this->processingBranches);
    }


    function it_should_implement_interface()
    {
        $this->shouldImplement(BranchInfoInterface::class);
    }

    function it_should_have_master_branch()
    {
        $this->getMasterBranch()->shouldReturn($this->masterBranch);
    }

    function it_should_have_result_branch()
    {
        $this->getResultBranch()->shouldReturn($this->resultBranch);
    }

    function it_should_have_worker_branches()
    {
        $this->getProcessingBranches()->shouldReturn($this->processingBranches);
    }
}
