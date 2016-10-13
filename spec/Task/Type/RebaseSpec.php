<?php

namespace spec\Hellosworldos\GitTools\Task\Type;

use Hellosworldos\GitTools\Task\Type\Rebase;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RebaseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Rebase::class);
    }
}
