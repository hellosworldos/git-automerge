<?php

namespace spec\Hellosworldos\Component\GitTools;

use GuzzleHttp\Stream\Stream;
use Hellosworldos\Component\GitTools\StreamFactory;
use Hellosworldos\Component\GitTools\StreamFactoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StreamFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StreamFactory::class);
        $this->shouldImplement(StreamFactoryInterface::class);
    }

    function it_should_make_writable_file_stream()
    {
        $this->makeWritableFile('/path/to/file')->shouldBeAnInstanceOf(Stream::class);
    }
}
