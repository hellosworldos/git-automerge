<?php

namespace spec\Hellosworldos\GitTools\Task\Type\Git;

use Hellosworldos\GitTools\Task\Type\Git\Merge;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MergeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Merge::class);
    }
}
