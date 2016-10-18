<?php

namespace spec\Hellosworldos\GitTools;

use Hellosworldos\GitTools\StreamFactory;
use Hellosworldos\GitTools\StreamFactoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StreamFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StreamFactory::class);
        $this->shouldImplement(StreamFactoryInterface::class);
    }
}
