<?php

namespace spec\Hellosworldos\GitTools\Task\Type\Git;

use Hellosworldos\GitTools\Task\Type\Git\Rebase;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RebaseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Rebase::class);
    }
}
