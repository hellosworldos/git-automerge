<?php

namespace spec\Hellosworldos\GitTools\Task\Type\Git;

use Hellosworldos\GitTools\Task\Type\Git\Squash;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SquashSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Squash::class);
    }
}
