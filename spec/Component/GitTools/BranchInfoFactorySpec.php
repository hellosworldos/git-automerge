<?php

namespace spec\Hellosworldos\Component\GitTools;

use Hellosworldos\Component\GitTools\BranchInfoFactory;
use Hellosworldos\Component\GitTools\BranchInfoFactoryInterface;
use Hellosworldos\Component\GitTools\BranchInfoInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BranchInfoFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(BranchInfoFactory::class);
        $this->shouldImplement(BranchInfoFactoryInterface::class);
    }

    function it_should_build_object()
    {
        $this->build('master', 'result', ['processing1', 'processing2'])
            ->shouldBeAnInstanceOf(BranchInfoInterface::class);

        $this->shouldThrow()->during('build', ['master', 'result', 'some_string']);
        $this->shouldThrow()->during('build', ['master', 'result']);
    }
}
